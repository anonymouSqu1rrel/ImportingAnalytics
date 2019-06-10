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

class AnalyticsController extends Controller
{
  public static function GetBestSellingMerchant()
  {

    //since we only need query and a little bit of logic to get data I will call it from controller. If I had more logic, I would cale it from somewhre else (Service or something simillar)
    $data =  DB::SELECT("select dm.merchant_id, m.first_name, m.last_name, SUM(dm.sales_total) as allSales from daily_merchants dm
    LEFT JOIN merchants m ON m.id_merchant = dm.merchant_id
    group by merchant_id order by allSales desc LIMIT 1");

    if(isset($data[0]))
    {
      $merchantRaw = $data[0];
      $merchant = $merchantRaw->merchant_id . ', ' . $merchantRaw->first_name . ', ' . $merchantRaw->last_name;
      return ("Merchant with most sales is: $merchant");
    }
    else
    {
      return ("Couldn't find any merchants");
    }
  }

  public static function GetBestSellingFunnelForMerchant($idMerchant)
  {
    //since we only need query and a little bit of logic to get data I will call it from controller. If I had more logic, I would call it from somewhre else (Service or something simillar)
    $data =  DB::SELECT("select funnel_id, SUM(sales_total) as allSales from daily_funnels
      where merchant_id = ? group by funnel_id order by allSales desc LIMIT 1;", [$idMerchant]);

    if(isset($data[0]))
    {
      $funnel = $data[0];
      return "Funnel with most sales is: $funnel->funnel_id";
    }
    else
    {
      return "Couldn't find any funnel";
    }
  }

  public static function GetAvgPerMerchantPerDay()
  {
    $data =  DB::SELECT("select avg(sales_total), DATE(analytics_date)as  dateD, merchant_id from daily_merchants 
     group by merchant_id, dateD 
     order by merchant_id, dateD;");
    
    return $data;
  }
}