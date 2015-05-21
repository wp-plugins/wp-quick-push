<?php
function quickpushme($AppID, $RestApiKey, $Message, $sendToChannels = null, $JoeJson = false) {
    $url = 'https://api.parse.com/1/push/';
    if(!$JoeJson){
        $data = array(
            'expiry' => 1451606400,
            'data' => array('alert' => $Message,'badge' => 'Increment'),
        );
    } else {
        $data = array(
            'expiry' => 1451606400,
            'data' => $Message,
        );
    }
    if (get_option('quickpush_enableSound') == 'true'){
        $data['data']['sound'] = "";
    }
    if (get_option('quickpush_noChannel') == 'true') {
    	$data['where'] = '{}';
    } else {
    	if ($sendToChannels == null) {
            $data['channel'] = '';
	}
	else {
            $data['channels'] = explode(',', $sendToChannels);
    	}
    }
    $_data = json_encode($data , JSON_UNESCAPED_SLASHES);
    $headers = array(
	    'X-Parse-Application-Id: ' . $AppID,
	    'X-Parse-REST-API-Key: ' . $RestApiKey,
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($_data),
	);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    if ($result === FALSE) 
        die(curl_error($curl));	
    curl_close($curl);
    return $result;
}
?>