<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\MddProfile;
use App\Models\User;

class ScrapeProfile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mdd_id;

    public function __construct($mdd_id) {
        $this->mdd_id = $mdd_id;
    }

    public function handle(): void {
        list($name, $country) = $this->get_profile($this->mdd_id);

        $profile = MddProfile::where('id', $this->mdd_id)->first();
        if ($profile) {
            // already exists
            return;
        }

        $newProfile = new MddProfile();
        $newProfile->id = $this->mdd_id;
        $newProfile->name = $name;
        $newProfile->plain_name = preg_replace('/\^\w/', '', $name);
        $newProfile->country = $country;

        $user = User::where('mdd_id', $this->mdd_id)->first();
        if ($user) {
            $newProfile->user_id = $user->id;
        }

        $newProfile->processStats();

        $newProfile->save();
    }


    public function get_profile($id) {
        $query = http_build_query([
            'id' => $id
        ]);

        $url = 'https://q3df.org/api/getUser?' . $query;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response === false) {
            return null;
        }

        $user = json_decode($response, true);
        return [$user['visname'], strtoupper($user['country'])];
    }
}
