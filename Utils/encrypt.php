<?php

function encrypt($toEncrypt)
{
    if ($toEncrypt) {

        $encryptedCode = base64_encode($toEncrypt);

        return openssl_encrypt($encryptedCode, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
    } else {
        return null;
    }
}

function decrypt($toDecrypt)
{
    $decrypted = openssl_decrypt($toDecrypt, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);

    if ($decrypted) {
        return base64_decode($decrypted);
    } else {
        return null;
    }
}
