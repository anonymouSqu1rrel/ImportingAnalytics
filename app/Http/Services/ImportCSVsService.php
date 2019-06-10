<?php

namespace App\Http\Services; 

use App\Http\Controllers\Controller; 
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Throwable;
use StdClass;
use Response;
use DateTime;
use DB;
use App\Http\Helpers\GenericHelper; 
use App\Http\Helpers\ImportCSVsHelper; 
use App\DailyMerchants;

class ImportCSVsService extends Controller
{
  public static function ParseAndInsertDailyMerchants($mySaveDir, $filename)
  {
    $url = "https://app.periscopedata.com/api/carthook/chart/csv/d5345630-811c-cd5a-b3e2-c4a6ac1dae1a/265769"; 
    $completeSaveLoc = $mySaveDir . $filename;
    GenericHelper::DownloadFile($url, $completeSaveLoc); //download file so you can read it line by line later
    ImportCSVsHelper::ImportCsv("DailyMerchants", 5000, $completeSaveLoc);
  }

  public static function ParseAndInsertHourlyMerchants($mySaveDir, $filename)
  {
    $url = "https://app.periscopedata.com/api/carthook/chart/csv/5ab06803-29bf-76b2-6a5a-ad7cf4b7fc21/284541"; 
    $completeSaveLoc = $mySaveDir . $filename;
    GenericHelper::DownloadFile($url, $completeSaveLoc); //download file so you can read it line by line later
    ImportCSVsHelper::ImportCsv("HourlyMerchants", 5000, $completeSaveLoc);
  }

  public static function ParseAndInsertHourlyFunnels($mySaveDir, $filename)
  {
    $url = "https://app.periscopedata.com/api/carthook/chart/csv/b5798a66-e694-a429-cc5e-2f9e163f6438/284541"; 
    $completeSaveLoc = $mySaveDir . $filename;
    GenericHelper::DownloadFile($url, $completeSaveLoc); //download file so you can read it line by line later
    ImportCSVsHelper::ImportCsv("HourlyFunnels", 5000, $completeSaveLoc);
  }

  public static function ParseAndInsertDailyFunnels($mySaveDir, $filename)
  {
    $url = "https://app.periscopedata.com/api/carthook/chart/csv/b3bb3bbd-0ea3-8234-64bd-3cb474631c30/284541"; 
    $completeSaveLoc = $mySaveDir . $filename;
    GenericHelper::DownloadFile($url, $completeSaveLoc); //download file so you can read it line by line later
    ImportCSVsHelper::ImportCsv("DailyFunnels", 5000, $completeSaveLoc);
  }

  public static function GenerateMerchantTable()
  {
    //names are random generated nonsense string. If I would need to generate something more real I would use Faker and generate it into another table, than randomly select from it instead of generating random nonsense strings.
    $query = "
      INSERT IGNORE INTO merchants (id_merchant, first_name, last_name) 
      select merchant_id, conv(floor(rand() * 99999999999999), 20, 36) , conv(floor(rand() * 99999999999999), 20, 36)  FROM (
      select distinct merchant_id from daily_merchants 
      union 
      select distinct merchant_id from hourly_merchants 
      union
      select distinct merchant_id from hourly_funnels
      union
      select distinct merchant_id  from daily_funnels
      ) as t";

      DB::raw($query);
  }

}
