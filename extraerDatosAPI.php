function getAPIdata()
{
    set_time_limit(600);
    $url = "https://instagram28.p.rapidapi.com/medias";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //añadimos los headers

    $headers = array(
    "X-RapidAPI-Host: instagram28.p.rapidapi.com",
    "X-RapidAPI-Key: 83a70cd171msh533a87840ed50cep1d7ad8jsn12c6a48f1868",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    //añadimos parámetros

    $id_instagram = 49767598151;

    $params = array(
        'user_id' => $id_instagram,
        'batch_size' => '1',
    );

    $urlConParam = $url . '?' . http_build_query($params);

    curl_setopt($curl, CURLOPT_URL, $urlConParam);

    //for debug only!

    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);

    if ($resp === false){
        $resp = curl_error($curl);
    }else{
        $dataDecoded = json_decode($resp, true);
        if($dataDecoded['data']){
            //dump($resp);
            
            $decodedResp = json_decode($resp, true);
            
            $publicacionTexto = $decodedResp['data']['user']['edge_owner_to_timeline_media']['edges'][0]['node']['edge_media_to_caption']['edges'][0]['node']['text'];
            $fechaPub = $decodedResp['data']['user']['edge_owner_to_timeline_media']['edges'][0]['node']['taken_at_timestamp'];
            $link = $decodedResp['data']['user']['edge_owner_to_timeline_media']['edges'][0]['node']['shortcode'];
            
            $sql = "UPDATE social_media SET textoPub = '" . $publicacionTexto . "', fechaPub = '" . $fechaPub . "', link ='" . $link . "', fechaMod = '" . date("Y/m/d h:i:s") . "' WHERE id = 1";
            mysql_query($sql);
        }
    }

}