<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller; 
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Throwable;
use StdClass;
use Response;
use DateTime;
use DB; 
use App\Http\Services\ImportCSVsService;

class ImportCSVsController extends Controller
{
  public function index($type)
  {

    $mySaveDir = "../CSVs/";
    try
    {
      switch ($type) { //specify type to import desired csv. This can help in case we need to import only one file, not all of them (for example, if one CSV is not available at time of import)
        case 'all':
          ImportCSVsService::ParseAndInsertDailyMerchants($mySaveDir, "dailyMerchant");
          ImportCSVsService::ParseAndInsertHourlyMerchants($mySaveDir, "hourlyMerchant");
          ImportCSVsService::ParseAndInsertHourlyFunnels($mySaveDir, "hourlyFunnels");
          ImportCSVsService::ParseAndInsertDailyFunnels($mySaveDir, "dailyFunnels");
          ImportCSVsService::GenerateMerchantTable();
          break;
        
        default:
          abort(500, 'Wrong type specified!');
          break;
      }

    } catch (Throwable  $e)
    {
      dd($e);
    }
  }


}