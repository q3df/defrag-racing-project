<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\External\Q3DFLastRecordsApi;
use App\Models\User;
use App\Models\Map;
use App\Models\Record;
use App\Models\RecordHistory;
use App\Models\MddProfile;

use App\Jobs\ProcessNotificationsJob;

class ImportLastMddRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;

    public function __construct() {}

    public function handle(): void{
        $api = new Q3DFLastRecordsApi();
        echo ("Starting the ImportLastMddRecords from $api->url") . PHP_EOL;

        list($count, $records) = $api->getMddRecords();

        if (count($records) === 0) {
            echo ('No records found !') . PHP_EOL;
        } else {
            $this->processRecords($records);
        }

        echo ("Finished Running the ImportLastMddRecords.") . PHP_EOL;
    }

    private function processRecords($records) {
        foreach($records as $record) {
            $find = Record::query()
                    ->where('physics', $record['physics'])
                    ->where('mode', $record['mode'])
                    ->where('mdd_id', $record['mdd_id'])
                    ->where('mapname', $record['map'])->first();

            if (! $find) {
                $this->insertRecord($record);
                continue;
            }

            if ($find->time === $record['time']) {
                echo ("Duplicate Found [" . $find->name . "] (" . $find->time . ") (" . $find->mapname . ") (" . $find->physics . ")") . PHP_EOL;
                continue;
            }

            if ($find->time !== $record['time']) {
                $this->insertHistoricRecord($find, $record);
            }

            $this->insertRecord($record);
        }
    }

    private function insertHistoricRecord($oldrecord, $newrecord) {
        $historic = new RecordHistory();
        $historic->fill($oldrecord->toArray());

        $historic->save();

        $oldrecord->delete();
    }

    private function insertRecord($record) {
        echo ("Inserting Record [" . $record['name'] . "] (" . $record['time'] . ") (" . $record['map'] . ") (" . $record['physics'] . ") (" . $record['mdd_id'] . ")") . PHP_EOL;

        $newrecord = new Record();

        $record['map'] = strtolower($record['map']);

        $newrecord->name = $record['name'];
        $newrecord->mapname = $record['map'];
        $newrecord->mdd_id = $record['mdd_id'];
        $newrecord->date_set = $record['date'];
        $newrecord->physics = $record['physics'];
        $newrecord->mode = $record['mode'];
        $newrecord->country = $record['country'];
        $newrecord->time = $record['time'];
        $newrecord->gametype = $record['mode'] . '_' . $record['physics'];

        $user = User::where('mdd_id', $record['mdd_id'])->first();

        if ($user) {
            $newrecord->user_id = $user->id;
        }

        $newrecord->save();

        $serverMap = Map::where('name', $record['map'])->first();

        if ($serverMap) {
            $serverMap->processRanks();
            $serverMap->processAverageTime();
        }

        $mdd_profile = MddProfile::where('id', $newrecord->mdd_id)->first();

        if ($mdd_profile) {
            $mdd_profile->processStats();
        } else {
            $mdd_profile = new MddProfile();
            $mdd_profile->id = $newrecord->mdd_id;
            $mdd_profile->country = $record['country'];
            $mdd_profile->name = $record['name'];
            $mdd_profile->plain_name = preg_replace('/\^\w/', '', $record['name']);

            $user = User::where('mdd_id', $newrecord->mdd_id)->first();
            if ($user) {
                $mdd_profile->user_id = $user->id;
            }

            $mdd_profile->save();
        }

        ProcessNotificationsJob::dispatch($newrecord);
    }

    private function get_int_parameter($name) {
        $param = $this->$name;

        return intval($param);
    }
}
