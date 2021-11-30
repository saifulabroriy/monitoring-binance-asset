<?php
    function sendMessage($msg){
        $token = "YOUR_TOKEN";
        $chat_id = YOUR_CHAT_IF;

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $msg;

        $curl = curl_init($url);

        curl_exec($curl);

        // Error Handler
        if (curl_errno($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // Tutup curl
            curl_close($curl);
        }
    }