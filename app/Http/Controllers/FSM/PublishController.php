<?php

namespace App\Http\Controllers\FSM;

use App\Http\Controllers\Controller;
use App\Models\Publish;
use DateTime;
use Illuminate\Support\Facades\Log;

class PublishController extends Controller
{
    public function index()
    {
        $date = new DateTime;
        $date->modify('+1 minute');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $results = Publish::whereDate('datetime', '<=', $formatted_date)->get();
        Log::info($results);
    }
}
