<?php
if( !function_exists('send_whatsapp_callmebot') ){
    /****************************************************
     https://www.callmebot.com/blog/free-api-whatsapp-messages/
     *****************************************************/
    function send_whatsapp_callmebot( $message){
        $number = "+33624796455"; // Numéro qui reçoit les notifs (à personnaliser)
        $apikey = "999676" ; // à générer sur le site https://www.callmebot.com
        $url = "https://api.callmebot.com/whatsapp.php?phone=".$number."&text=".urlencode($message)."&apikey=".$apikey;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}
