function getAPIdata()
{
$url = "https://LaAPIqueQuieras";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
"NombredelHeader: contenido",
"NombredelHeader: contenido",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
if ($resp === false)
$resp = curl_error($curl);
//dump($resp);
curl_close($curl);

$decodedResp = json_decode($resp, true);

$publicacionTexto = $decodedResp['data']['media'][0]['caption'];
$fechaPub = $decodedResp['data']['media'][0]['taken_at'];
$link = $decodedResp['data']['media'][0]['shortcode'];

$sql = "UPDATE social_media SET textoPub = '". $publicacionTexto ."', fechaPub = '". $fechaPub . "', link ='". $link . "', fechaMod = '". date("Y/m/d h:i:s") ."' WHERE id = 1";
mysql_query($sql);

}