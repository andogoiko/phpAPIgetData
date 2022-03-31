// se comprueba la hora de la última actualización y se actualiza

date_default_timezone_set('europe/madrid'); //obligamos a la hora a ser como la zona GMT de Madrid

$sql = "SELECT * FROM social_media";
$result = mysql_query($sql);

$add = round(60 * 60);
$lastRefreshDate = strtotime(mysql_fetch_array($result)["fechaMod"]) + $add;

$dateNow = strtotime(date("Y/m/d H:i:s")) + $add;

$delay = 3600 * 2.5;

$timeNow = date('H:i');

if ($timeNow >= date('08:00') && $timeNow <= date('21:00')) { 
    if (($dateNow - $lastRefreshDate)>= $delay) {
        getAPIdata();
    }
}