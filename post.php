<?php

    ini_set('error_reporting', E_ALL);
    require_once('users.php');
    $response = null;
    $user_name = null;

    /*
        Fallback para versiones viejas de PHP que no soportan hash_equals.
    */
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

    /*
        Peticion CURL a la API de mattermost para enviar el mensaje.
        $payload es es un string, contiene el payload con el mensaje a enviar a la API.
        Ejemplo de payload: payload={"username": "robot", "text": "Hello, this is some text."}
        Para enviar el username hay que habilitar Overriding of Usernames from Webhooks.
        https://docs.mattermost.com/developer/webhooks-incoming.html
    */
    function enviarMensaje($payload){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://coopes.facttic.org.ar/hooks/9rkswiwcpp8y3ees65rdj77frr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json',
                                            'Connection: Keep-Alive'
                                            ));
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:  "));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $curl_response = curl_exec($ch);

        $response = [
            'curl_response' => $curl_response,
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
        ];

        curl_close($ch);

        // die(var_dump($response));
        return $response;
    }


    if($_POST['enviar'])
    {
        /*
            Elimina los saltos de linea que genera el textarea cuando pierde el foco al precionar enter.
        */
        $text = preg_replace( "/\r|\n/", "", $_POST['text'] );

        foreach ($users as $user => $user_password) {

            /*
                Compara el password ingresado con los que hay en users.php
            */
            if(hash_equals($user_password, crypt($_POST['pswd'], $user_password)))
            {
                $user_name = $user;
            }

        }
        if($user_name){
            $payload = "payload={\"username\": \"@".$user_name."\", \"text\": \"## [![matterostbost](".$_SERVER['HTTP_REFERER']."img/".$user_name.".jpg)](".$_SERVER['PHP_SELF'].") ***".$user_name." dice:*** ".$text."\"}";
            $response = enviarMensaje($payload);
        }
        else{
            $response = ['curl_response' => 'No existe el usuario.', 'http_code' => '666'];
        }

        if($response['http_code']>=200 && $response['http_code']<300){
            header("Location: index.php?status=ok&code=".$response['http_code']);
        }
        else{
            header("Location: index.php?status=fail&code=".$response['http_code']);
            error_log("ERROR: ".$response['curl_response'], 1, "smarbos@gmail.com");
        }
        if($response['http_code'] == 666) {
            header("Location: index.php?status=bad-pswd&code=".$response['http_code']);
        }
    }

?>
