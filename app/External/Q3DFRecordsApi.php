<?php

namespace App\External;

use Carbon\Carbon;

class Q3DFRecordsApi {
    public $url = "https://q3df.org/api/getRecords";

    public function getMddRecords($page = 1, $per_page = 100, $api_key = null) {
        $query = http_build_query([
            'page' => intval($page),
            'per_page' => intval($per_page),
            'key' => $api_key ?: $api_key
        ]);

        $ch = curl_init($this->url . '?' . $query);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);

        curl_close($ch);

        if ($response === false || $response_status !== 200) {
            return [0, 0, []];
        }

        $json = json_decode($response, true);
        return [$info['starttransfer_time'], $json['count'] ?? 0, $this->mapRecords($json)];
    }

    private function mapRecords($records) {
        $mappedRecords = [];

        foreach($records['data'] as $record) {
            $mappedRecords[] = $this->getRecord($record);
        }

        return $mappedRecords;
    }

    private function getRecord($recordPart) {
        $date = Carbon::createFromTimestamp($recordPart['UnixTimestamp'], 'Europe/Berlin');
        $player = $this->get_player_from_mdduser($recordPart['User']);
        $time = $recordPart['MsTime'];
        $map = trim($recordPart['Map']);

        $physics = trim($recordPart['GameType']);
        $physicsParts = explode('-', $physics);

        $player['time'] = $time;
        $player['map'] = $map;
        $player['physics'] = $physicsParts[0];
        $player['mode'] = $physicsParts[1];
        $player['date'] = $date->toDateTimeString();

        return $player;
    }

    private function get_player_from_mdduser($mdduser) {
        $country = $mdduser['Country'] ?? '_404';

        if ($country === 'nocountry' || !$country) {
            $country = '_404';
        }

        return [
            'name'      =>  $mdduser['Visname'],
            'country'   =>  strtoupper($country),
            'mdd_id'    =>  $mdduser['Id']
        ];
    }
}
