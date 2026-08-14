<!DOCTYPE HTML>
<html>  
<body>

<?php
    // --------------------------------
    // Enable Client-Side Server Errors
    // ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);
    // --------------------------------

    $webhookURL = ""; // YOUR SLACK WEBHOOK URL GOES HERE

    function sendWebhookMessage($string) {
        $curl = curl_init($GLOBALS['webhookURL']);
        curl_setopt($curl, CURLOPT_URL, $GLOBALS['webhookURL']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = "{'text':'". $string ."'}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    function lookupIP($ipAddr) {
        $url = "http://ip-api.com/json/" . $ipAddr . "?fields=21749465";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $out;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {        
        $clientIP = $_SERVER['REMOTE_ADDR'];
        $clientUA = $_SERVER['HTTP_USER_AGENT'];
        $statsIP = lookupIP($clientIP);
        //print_r($statsIP);
        if ($statsIP["status"] == "success") {
            $text = <<<TXT
            KNOCK KNOCK!
            Someone has requested door access.
            ```
            Details:
            * IP Address: $clientIP
            * Country: $statsIP[country]
            * Region Name: $statsIP[regionName]
            * City: $statsIP[city]
            * District: $statsIP[district]
            * ISP: $statsIP[isp]
            * Organization: $statsIP[org]
            * AS Number: $statsIP[as]
            * AS Name: $statsIP[asname]
            * Reverse DNS: $statsIP[reverse]
            * Mobile: $statsIP[mobile]
            * Proxy/VPN: $statsIP[proxy]
            * Hosting: $statsIP[hosting]
            * User Agent: $clientUA
            ```
            TXT;
            $slackOut = sendWebhookMessage($text);
            if ($slackOut == "ok") {
                $GLOBALS["worked"] = true;
            } else {
                $GLOBALS["worked"] = false;
            }
        } else {
            $GLOBALS["worked"] = false;
        }
    }
?>

<style>
    input[type="submit"] {
        width: 500px;
        height: 500px;
        font-size: 300px;
    }
    #success {
        color: green;
        font-weight: bold;
    }
    #fail {
        color: red;
        font-weight: bold;
    }
</style>

<h1>Door Access Knock-Knock Prototype</h1>
<form action="" method="post">
    <input type="submit" value="&#128718;">
</form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($GLOBALS["worked"] == true) {
            echo "<p id='success'><b>Notificaiton sent!</b></p>";
        } else {
            echo "<p id='fail'><b>Fail. Notificaiton not sent.</b></p>";
        }
    }
?>

</body>
</html>