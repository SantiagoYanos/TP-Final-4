<?php

function encrypt($toEncrypt)
{
    if ($toEncrypt) {

        $encryptedCode = base64_encode($toEncrypt);

        return openssl_encrypt($encryptedCode, "AES-128-CBC", SECRET, 0, $_SESSION["token"]);
    } else {
        return null;
    }
}

function decrypt($toDecrypt)
{
    $decrypted = openssl_decrypt($toDecrypt, "AES-128-CBC", SECRET, 0, $_SESSION["token"]);

    if ($decrypted) {
        return base64_decode($decrypted);
    } else {
        return null;
    }
}
