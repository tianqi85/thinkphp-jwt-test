<?php
include "vendor/autoload.php";
use Namshi\JOSE\SimpleJWS;
defined('SSL_KEY_PASSPHRASE') or define('SSL_KEY_PASSPHRASE' , 'test');
$username = 'correctUsername';
$pass="ok";

if ($username == 'correctUsername' && $pass == 'ok') {
   // $user = Db::loadUserByUsername($username);

    $jws  = new SimpleJWS(array(
        'alg' => 'RS256'
    ));
    $jws->setPayload(array(
        'uid' => '123456',
        'shop_id' => '35'
    ));

    $privateKey = openssl_pkey_get_private("file://../rsa_private_key.pem", SSL_KEY_PASSPHRASE);
    $jws->sign($privateKey);
    $test=$jws->getTokenString();
    setcookie('identity', $jws->getTokenString());
    echo "<br/><br/>";

    //$jws1        = SimpleJWS::load($_COOKIE['identity']);
    $jws1        = SimpleJWS::load($test);
        $public_key = openssl_pkey_get_public("file://../rsa_public_key.pem");

        // verify that the token is valid and had the same values
        // you emitted before while setting it as a cookie
        if ($jws1->isValid($public_key, 'RS256')) {
            $payload = $jws1->getPayload();
            var_dump($payload);

            //echo sprintf("Hey, my JS app just did an action authenticated as user #%s", $payload['uid']);
        }
}
