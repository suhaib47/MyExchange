<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class CurrencyController extends Controller
{
    private $api_version = "1";

    //returns all latest currencies
    public function index(Request $request){
        // get today's date
        $today = Carbon::now();
        $curDate = $today->format('d M Y');

        // prepare API call
        $apiVersion = $this->api_version;
        $date = $today->format('Y-m-d');
        $endpoint = 'currencies';
        $api_url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@$apiVersion/latest/$endpoint.json";

        $json_response = Http::get($api_url);
        $assoc_response = json_decode($json_response, true);

        return view('index', ['currentDate' => $curDate, 'currencies' => $json_response]);
    }

    public function show(Request $request, $curr_code, $date = 'latest'){
        // prepare API call
        $apiVersion = $this->api_version;
        $endpoint = "currencies/$curr_code";
        // check if POST form is submitted for a specific date, else 'latest' date is used as default
        if (isset($_POST['rate_submit'])) {
            $date = trim($_POST['rates_date']);
            $date = stripslashes($date);
            $date = htmlspecialchars($date);
        }

        $api_url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@$apiVersion/$date/$endpoint.json";

        // get json data from API
        $json_response = Http::get($api_url);

        // convert json response into associative array
        $assoc_response = json_decode($json_response, true);
        $assoc_response['base_curr'] = $curr_code;

        return view('show')->with('response', $assoc_response);
    }

    public function download_csv(Request $request, $curr_code, $date){
        $apiVersion = $this->api_version;
        $endpoint = "currencies/$curr_code";
        $api_url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@$apiVersion/$date/$endpoint.json";
        $json_response = Http::get($api_url);
        $assoc_response = json_decode($json_response, true);

        // prepare csv file download
        $filename = 'rates.csv';
        $headers = [
            //'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            // 'Content-Disposition' => "attachment; filename=$filename",
            // 'Expires'             => '0',
            // 'Pragma'              => 'public'
        ];

        // create and write to csv file
        $handle = fopen($filename, 'w+');
        fputcsv($handle, [$date]);
        foreach($assoc_response[$curr_code] as $target_curr => $rate){
            fputcsv($handle, ["$curr_code/$target_curr", sprintf("%f", $rate)]);
        }
        fclose($handle);

        return Response::download($filename, $filename, $headers);

    }
}
