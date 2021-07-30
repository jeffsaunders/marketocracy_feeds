<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Set Database Variables
$dbHost = "192.168.111.211";
$dbUser = "marketocracy";
$dbPass = "KfabyZcbE3";
$dbName = "feed2";

//Connect to feed_data DB / MySQL with PDO_MYSQL
try{
        $fLink = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $fLink->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $error){
        // Log any error to /var/log/httpd/beta-pdo_log
        file_put_contents("/var/log/httpd/beta-pdo_log", "-----\rDate: ".date('Y-m-d H:i:s')."\rFile: ". __FILE__ ."\rLine Number: ". __LINE__ ."\rVars:\r".dump_vars(get_defined_vars())."\r", FILE_APPEND);
        die($error->getMessage());
}




    $sym = "PGN,TMK,MPC,KBAL,DTSI,STRZA,KE,MNK,VLO,LUV,PEIX,PJC,ALK,LRCX,X,AIZ,HLX,SAFM,ACCO,TSN,NR,PFG,UIHC,HPQ,CMO,WRB,CMC,LEA,ONNN,CXP,UVE,DDS";
    //Create array from comma delimited string
	$aSymbols = explode(",", $sym);
    //Make symbols into a comma seperated string surround by SINGLE quotes for mysql
	$symbols = "'".implode("','", $aSymbols)."'";
/*
    $query = "SELECT Name as companyName, Symbol as symbol, Last as CurrentPrice, ChangeFromPreviousClose as chang
                FROM `feed2`.`stock_feed`
                WHERE `Symbol` in (".$symbols.")";

				try{
					$rsSymbols = $fLink->prepare($query);

					$aValues = array(
						'companyName'   => $companyName,
						'symbol'        => $symbol,
                        'currentPrice'  => $currentPrice,
                        'change'        => $chang
					);
				}
				catch(PDOException $error){
					// Log any error
					file_put_contents($_SESSION['pdo_log'], "-----\rDate: ".date('Y-m-d H:i:s')."\rFile: ". __FILE__ ."\rLine Number: ". __LINE__ ."\rVars:\r".dump_vars(get_defined_vars())."\r", FILE_APPEND);
				}
*/
    $query = "SELECT Name as companyName, Symbol as symbol, Last as CurrentPrice, ChangeFromPreviousClose as chang
                FROM `feed2`.`stock_feed`
                WHERE `Symbol` in (".$symbols.")";
	try{
		$rsSymbols = $fLink->prepare($query);
		$rsSymbols->execute();
	}
	catch(PDOException $error){
		// Log any error
			file_put_contents($_SESSION['pdo_log'], "-----\rDate: ".date('Y-m-d H:i:s')."\rFile: ". __FILE__ ."\rLine Number: ". __LINE__ ."\rVars:\r".dump_vars(get_defined_vars())."\r", FILE_APPEND);
	}
    $count = '0';
	while($foo = $rsSymbols->fetch(PDO::FETCH_ASSOC)){

    //insert data into MD Array
    foreach($foo as $key => $value){
        if($key == "chang"){
        $key = "change";
        }
        $s = $foo['symbol'];
        $aTrades[$s][$key] = $value;
        }
    $count++;

/*print "<pre>";
print_r($foo);
print "</pre>";*/

	}
print "<h1>sql results</h1><br>";

print "<pre>";
print_r($aTrades);
print "</pre>";


print "<h1>yql results</h1><br>";

$json = '{"query":{"count":2,"created":"2015-01-20T19:08:12Z","lang":"en-US","results":{"quote":[{"symbol":"LUV","AverageDailyVolume":"8781180","Change":"+0.98","DaysLow":"39.72","DaysHigh":"40.76","YearLow":"20.22","YearHigh":"43.19","MarketCapitalization":"27.462B","LastTradePriceOnly":"40.46","DaysRange":"39.72 - 40.76","Name":"Southwest Airline","Symbol":"LUV","Volume":"6169040","StockExchange":"NYSE"},{"symbol":"AAPL","AverageDailyVolume":"50187000","Change":"+1.5798","DaysLow":"106.50","DaysHigh":"108.78","YearLow":"70.5071","YearHigh":"119.75","MarketCapitalization":"630.9B","LastTradePriceOnly":"107.5698","DaysRange":"106.50 - 108.78","Name":"Apple Inc.","Symbol":"AAPL","Volume":"28270052","StockExchange":"NasdaqNM"}]}}}';
$phpObj =  json_decode($json);

print "<pre>";
print_r($phpObj);
print "</pre>";
?>