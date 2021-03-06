<?php
function createSignature($method, $uri, $nonce, $variables)
{
    asort($variables);

    $varString = '';
    foreach ($variables as $key => $val) {
        $varString .= $key . '=' . $val;
    }

    return hash_hmac('sha256', $method . $uri . $nonce . $varString, API_SECRET);
}
