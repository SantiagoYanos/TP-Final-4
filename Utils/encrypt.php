<?php

function encrypt($toEncrypt)
{
    return openssl_encrypt($toEncrypt, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
}

function decrypt($toDecrypt)
{
    return openssl_decrypt($toDecrypt, "aes-128-cbc", SECRET, 0, $_SESSION["token"]);
}
