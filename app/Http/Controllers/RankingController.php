<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\PlayerRating;

class RankingController extends Controller
{
    public function index(Request $request) {

        // get VQ3 and CPM ratings
        $gametype = $request->input('gametype', 'run');

        $ratings = PlayerRating::query();
        $vq3Ratings = $ratings
            ->where('physics', 'vq3')
            ->where('mode', $gametype)
            ->orderBy('player_rating', 'DESC')
            ->paginate(50, ['*'], 'vq3Page')
            ->withQueryString();

        $ratings = PlayerRating::query();
        $cpmRatings = $ratings
            ->where('physics', 'cpm')
            ->where('mode', $gametype)
            ->orderBy('player_rating', 'DESC')
            ->paginate(50, ['*'], 'cpmPage')
            ->withQueryString();

        // get VQ3 and CPM ratings for the current user
        if ($request->user() && $request->user()->mdd_id) {
            $myVq3Rating = PlayerRating::where('mdd_id', $request->user()->mdd_id)
                ->where('physics', 'vq3')
                ->where('mode', 'run')
                ->with('user')
                ->first();

            $myCpmRating = PlayerRating::where('mdd_id', $request->user()->mdd_id)
                ->where('physics', 'cpm')
                ->where('mode', 'run')
                ->with('user')
                ->first();
        } else {
            $myVq3Rating = null;
            $myCpmRating = null;
        }

        // handle pagination
        $cpmPage = ($request->has('cpmPage')) ? min($request->cpmPage, $cpmRatings->lastPage()) : 1;
        $vq3Page = ($request->has('vq3Page')) ? min($request->vq3Page, $vq3Ratings->lastPage()) : 1;

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
}
