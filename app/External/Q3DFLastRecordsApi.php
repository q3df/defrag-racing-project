<?php

namespace App\External;

use Carbon\Carbon;
use App\External\Q3DFRecordsApi;

class Q3DFLastRecordsApi extends Q3DFRecordsApi {
    public $url = "https://q3df.org/api/getLastRecords";
}
