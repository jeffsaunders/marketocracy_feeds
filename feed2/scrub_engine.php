<?php

//print $string;
//$string = 'T,HES,JCP,F,S,LUV,ETN,AGX,HPQ,DBD,DSX,CSX,BAC,WFT,C,GCA,WG,KEM,GE,PFE,TE,ANF,TR,GWW,MDU,SWN,WMT,TOT,BP,DOM,WFC,GME,BA,REGI,VOXX,MGLN,AXP,ITC,AHL,MFC,LUX,BMO,APOL,RE,RNR,CLX,AGNC,V,TD,BLK,STRA,NYCB,ACE,KIM,OFG,JOY,FIG,OVTI,PFMT,TMK,AUO,WNC,LNC,WRLD,UVE,STS,UBS,UTL,PFG,MKC,AIZ,CS,LBY,GNW,FM,AFG,MRO,AEG,BMA,KNM,REX,LM,GBX,RY,BAM,GES,TRV,CYS,Y,DVN,NTP,UNM,PJC,TEX,CMO,SPW,BFR,ING,EVER,ALK';
$url_string = '_Token=EF2662FA141B4DC086F6A72B2D15AD2C&IdentifierType=Symbol&Identifiers='.$string;
$opts = array('http'=>
        array('method' =>'POST',
                'port' =>'443',
                'header' =>'Content-type: application/x-www-form-urlencoded',
                'content' =>$url_string
                )
			);
//print_r($opts);
$context = stream_context_create($opts);
$file = fopen('http://globalquotes.xignite.com/v3/xGlobalQuotes.json/GetGlobalDelayedQuotes', 'rb', false, $context) or die ("Xignite API Not Responding");
$results = @stream_get_contents($file);
/*$results=str_replace(' ','+',$results);
$pairs = explode('&',$results);
foreach($pairs as $value)
	{
	//print $value.'<br><br><br>';
	$pair = explode('=', $value);
	//print_r($pair);
	foreach($pair as $key => $value)
		{
		$$pair['0'] = $pair['1'];
		}
	}*/
//Need to trim the last } off the string as it doesnt have a , after it and therefore does not get removed in the explode() thus the -2 in the substr()
//Also needed to trim the [ and ] from the front and back of the package handed to us from the API
$results = substr($results, 1, -2);
print "<pre>";
print $results;
print "</pre>";


$json = explode("},", $results);
//$json[0] = $json[0]."}";
foreach($json as $key => $value)
    {
    //print $value."<br>";
    $value = $value."}";
    $obj = json_decode($value, TRUE);
    /*print "<pre>";
    print_r($obj);
    print "</pre>";
    print "<pre>";
    var_dump(json_decode($value));
    print "</pre>";*/
    foreach($obj as $key => $value)
            {
            $$key = $value;
            }
    foreach($obj['Security'] as $key => $value)
            {
            $$key = $value;
            }
    print "<br><br><br>".$Outcome."<br><br><br>";
    if($Outcome == "Success")
        {
        $symbol = $Symbol;
        //insert into symbol_frontbase
        $feed_insert = "INSERT INTO `symbol_frontbase` (
            `uid`,
            `symbol`,
            `Outcome`,
            `Date`)
            VALUES (
            '',
            '".$symbol."',
            '".$Outcome."',
            '".$Date."');";
        print $feed_insert;
        mysqli_query($data_link, $feed_insert);
        }
        else
            {
            $symbol = $Symbol;
            //insert into symbol_bad
            $feed_insert = "INSERT INTO `symbol_bad` (
                `uid`,
                `symbol`,
                `Message`,
                `Name`,
                `MarketIdentificationCode`)
                VALUES (
                '',
                '".$symbol."',
                '".$Message."',
                '".$Name."',
                '".$MarketIdentificationCode."');";
            print $feed_insert;
            mysqli_query($data_link, $feed_insert);
            }
    //$CIK = $obj['Security']['CIK'];
    //print "###############".$Identity."#####################";
    /*$feed_insert = "INSERT INTO `feed_data`.`stock_feed` (
            `uid`,
            `Outcome`,
            `Message`,
            `Identity`,
            `Delay`,
            `Date`,
            `Time`,
            `UTCOffset`,
            `Open`,
            `Close`,
            `High`,
            `Low`,
            `Last`,
            `LastSize`,
            `Volume`,
            `PreviousClose`,
            `PreviousCloseDate`,
            `ChangeFromPreviousClose`,
            `PercentChangeFromPreviousClose`,
            `Bid`,
            `BidSize`,
            `BidDate`,
            `BidTime`,
            `Ask`,
            `AskSize`,
            `AskDate`,
            `AskTime`,
            `High52Weeks`,
            `Low52Weeks`,
            `Currency`,
            `TradingHalted`,
            `CIK`,
            `CUSIP`,
            `Symbol`,
            `ISIN`,
            `Valoren`,
            `Name`,
            `Market`,
            `MarketIdentificationCode`,
            `MostLiquidExchange`,
            `CategoryOrIndustry`)
            VALUES (
            '',
            '".$Outcome."',
            '".$Message."',
            '".$Identity."',
            '".$Delay."',
            '".$Date."',
            '".$Time."',
            '".$UTCOffset."',
            '".$Open."',
            '".$Close."',
            '".$High."',
            '".$Low."',
            '".$Last."',
            '".$LastSize."',
            '".$Volume."',
            '".$PreviousClose."',
            '".$PreviousCloseDate."',
            '".$ChangeFromPreviousClose."',
            '".$PercentChangeFromPreviousClose."',
            '".$Bid."',
            '".$BidSize."',
            '".$BidDate."',
            '".$BidTime."',
            '".$Ask."',
            '".$AskSize."',
            '".$AskDate."',
            '".$AskTime."',
            '".$High52Weeks."',
            '".$Low52Weeks."',
            '".$Currency."',
            '".$TradingHalted."',
            '".$CIK."',
            '".$CUSIP."',
            '".$Symbol."',
            '".$ISIN."',
            '".$Valoren."',
            '".$Name."',
            '".$Market."',
            '".$MarketIdentificationCode."',
            '".$MostLiquidExchange."',
            '".$CategoryOrIndustry."'
            );";*/
    //print '<br><br>'.$feed_insert.'<br><br>';
    //mysqli_query($data_link, $feed_insert);
    //print "<br>-----------------------------------------------------------------------------------------------------<br>";
    }
?>
