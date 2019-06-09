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


class ImportCSVsHelper extends Controller
{

	public static function ImportCsv($table, $batchNumber, $completeSaveLoc)
	{

		$table = 'App\\' . $table;

		$file = fopen($completeSaveLoc, 'r');
	    $dataForImport = [];        

	    $batchCount = 1;
	    $columns = fgetcsv($file);
     	$countColumn = count($columns) - 1;
     	
	    while (($line = fgetcsv($file)) !== false) 
	    {
            $tmp = [];
	        for($i = 0; $i <= $countColumn; $i++)
	        {
        	   $tmp[$columns[$i]] = $line[$i];
	        }

         	$dataForImport[] = $tmp;
	        if($batchCount >= $batchNumber)
	        {
          		$table::insert($dataForImport);
	          	$dataForImport = [];
	          	$batchCount = 0;
	        }
	        $batchCount++;
      	}
	    
	    $table::insert($dataForImport);
	    fclose($file); 
	    unlink($completeSaveLoc);   
	}


}