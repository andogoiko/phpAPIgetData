function getAPIdata()
{
    set_time_limit(600);
    $url = "https://instagram29.p.rapidapi.com/user/ermuakirolak/media";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "X-RapidAPI-Host: instagram29.p.rapidapi.com",
        "X-RapidAPI-Key: 83a70cd171msh533a87840ed50cep1d7ad8jsn12c6a48f1868",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);

    if ($resp === false){
        $resp = curl_error($curl);
    }else{
        if(json_decode($resp, true)['data']){
            //dump($resp);

            $decodedResp = json_decode($resp, true);

            $publicacionTexto = $decodedResp['data']['media'][0]['caption'];
            $fechaPub = $decodedResp['data']['media'][0]['taken_at'];
            $link = $decodedResp['data']['media'][0]['shortcode'];

            $sql = "UPDATE social_media SET textoPub = '" . $publicacionTexto . "', fechaPub = '" . $fechaPub . "', link ='" . $link . "', fechaMod = '" . date("Y/m/d h:i:s") . "' WHERE id = 1";
            mysql_query($sql);
        }
    }

}