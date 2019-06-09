<?php

namespace App\Http\Helpers; 

use App\Http\Controllers\Controller; 
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Throwable;
use StdClass;
use Response;
use DateTime;
use DB;


class GenericHelper extends Controller
{
	public static function DownloadFile($url, $location)
	{
		$ch = curl_init($url);

	    $fp = fopen($location, "wb");

	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_exec($ch);
	    curl_close($ch);
	    fclose($fp);
	}

	public static function GetApiResponse($statusCode, $stackTrace = null, $message = null, $customData = null)
	{
		//Idea is that we always have same response, so we can debug when we call api.
		$response = new \StdClass();

		$response->statusCode = $statusCode;
		$response->message = $message;
		$response->stackTrace = $stackTrace;
		$response->customData = $customData;

		return $response;
	}
}