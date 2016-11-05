<?php

    ini_set('error_reporting', E_ALL);
    require_once('users.php');

    if(!function_exists('hash_equals'))
    {
        function hash_equals($str1, $str2)
        {
            if(strlen($str1) != strlen($str2))
            {
                return false;
            }
            else
            {
                $res = $str1 ^ $str2;
                $ret = 0;
                for($i = strlen($res) - 1; $i >= 0; $i--)
                {
                    $ret |= ord($res[$i]);
                }
                return !$ret;
            }
        }
    }

    function enviarMensaje($message){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://coopes.facttic.org.ar/hooks/9rkswiwcpp8y3ees65rdj77frr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json',
                                            'Connection: Keep-Alive'
                                            ));
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:  "));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }

    if($_POST['enviar'])
    {

        if($_POST['pswd']){

            foreach ($users as $user => $user_password) {
                if(hash_equals($user_password, crypt($_POST['pswd'], $user_password)))
                {
                    $string = "payload={\"username\": \"".$user."\", \"text\": \"***".$user." dice:*** ".$_POST['text']."\"}";
                    $status = enviarMensaje($string);
                }

            }
        }

        if($status != false){
            header("Location: index.php?status=ok&code=".$status);
        }
        else{
            header("Location: index.php?status=fail&code=".$status);
        }
    }

?>
