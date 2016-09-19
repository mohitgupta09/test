<?php
require('config.php');
require('signature.php');

/*
 * This will give you an integer number i.e nonce
 * Nonce is an integer, included into signature to prevent replay attacks.
*/
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API_URL . '/v2/nonce');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'HTTP_X_PUBLIC: ' . API_PUBLIC,
    ));
$output = curl_exec($ch);
curl_close($ch);
$data = json_decode($output);
echo '<pre>';
print_r($data->data->nonce);

/*
 * these all the paramaters required
 * lessonUrl - If user want to open some lesson then lessonUrl is mandatory other wise not
 * Grade - 1 to 6 get Primary Package, 7 to 9 - Primary and Secondary Package, 10 to 12 - Primary, secondary and bussines
 */
$fields = array(
    'email' => 'testamsi1@amsi.com',
    'name' => 'username',
    'surname' => 'usersurname',
    'phone_no' => '969515151',
    'gender' => 'female',
    'grade' => '6'
);
$fields_string = '';
foreach($fields as $key=>$value) {
    $fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, API_URL . '/v2/amsi');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'HTTP_X_PUBLIC: ' . API_PUBLIC,
        'HTTP_X_HASH:' . createSignature('POST', '/v2/amsi', $data->data->nonce, $fields)
    ));
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

$output = curl_exec($ch);
curl_close($ch);
echo '<pre>';
print_r(json_decode($output));
