<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\PlayerRating;

class RankingController extends Controller
{
    const PAGINATION_LIMIT = 50;
    const ACTIVE_PLAYERS_MONTHS = 3; //keep in sync with one in CalculateRatings.php

    public function index(Request $request) {

        // get VQ3 and CPM ratings
        $gametype = $request->input('gametype', 'run');
        $rankingtype = $request->input('rankingtype', 'active_players');

        $vq3Ratings = $this->getRatings('vq3', $gametype, $rankingtype);
        $cpmRatings = $this->getRatings('cpm', $gametype, $rankingtype);

        // get VQ3 and CPM ratings for the current user
        $myVq3Rating = $this->getMyRating($request, 'vq3', $gametype, $rankingtype);
        $myCpmRating = $this->getMyRating($request, 'cpm', $gametype, $rankingtype);

        // handle pagination
        $vq3Page = ($request->has('vq3Page')) ? min($request->vq3Page, $vq3Ratings->lastPage()) : 1;
        $cpmPage = ($request->has('cpmPage')) ? min($request->cpmPage, $cpmRatings->lastPage()) : 1;

        if ($request->has('vq3Page') && $request->get('vq3Page') > $vq3Ratings->lastPage()) {
            return redirect()->route('ranking', ['vq3Page' => $vq3Ratings->lastPage()]);
        }

        if ($request->has('cpmPage') && $request->get('cpmPage') > $cpmRatings->lastPage()) {
            return redirect()->route('ranking', ['cpmPage' => $cpmRatings->lastPage()]);
        }

        // render the view
        return Inertia::render('RankingView')
            ->with('vq3Ratings', $vq3Ratings)
            ->with('cpmRatings', $cpmRatings)
            ->with('myVq3Rating', $myVq3Rating)
            ->with('myCpmRating', $myCpmRating);
    }

    private function getRatings(string $physics, string $gametype, string $rankingtype): LengthAwarePaginator
    {
        $query = PlayerRating::query();
        $columnToChange = '';

        if ($rankingtype === 'active_players') {
            $query->where('last_activity', '>=', now()->subMonths(self::ACTIVE_PLAYERS_MONTHS));
            $columnToChange = 'active_players_rank';

        } elseif ($rankingtype === 'all_players') {
            $columnToChange = 'all_players_rank';
        }

        // TODO:
        // remove not used columns
        $query = $query
            ->with('user')
            ->where('physics', $physics)
            ->where('mode', $gametype)
            ->orderBy('player_rating', 'DESC')
            ->paginate(self::PAGINATION_LIMIT, ['*'], $physics . 'Page')
            ->withQueryString();

        $query->getCollection()->transform(function ($item) use ($columnToChange){
            $item->rank = $item->$columnToChange;
            unset($item->$columnToChange);
            return $item;
        });

        return $query;
    }

    private function getMyRating(Request $request, string $physics, string $gametype, string $rankingtype)
    {
        $query = PlayerRating::query();
        $columnToChange = '';

        if ($rankingtype === 'active_players') {
            $query->where('last_activity', '>=', now()->subMonths(self::ACTIVE_PLAYERS_MONTHS));
            $columnToChange = 'active_players_rank';

        } elseif ($rankingtype === 'all_players') {
            $columnToChange = 'all_players_rank';
        }

        if ($request->user() && $request->user()->mdd_id) {
            $query = $query
                ->where('mdd_id', $request->user()->mdd_id)
                ->where('physics', $physics)
                ->where('mode', $gametype)
                ->with('user')
                ->first();

            // NOTE:
            // Ideally we should change column name of selected ranking type to
            // "rank" as in getRatings function but I don't know how.
            // Because of that there we have additional ifs in RankingView.vue
            // and in Rating.vue.

        } else {
            $query = null;
        }

        return $query;
    }
}

