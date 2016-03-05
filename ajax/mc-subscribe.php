<?php
/*
Script:        AJAX Processing to Subscribe User to MailChimp
Package:       MailChimp Signup Form w/ Cookies
Package URI:   https://github.com/bfa/mc-signup-form
Author:        Brent Alexander
Author URI:    http://www.bfa.me
Author Email:  brent@bfa.me
*/

// PHP Console
// require_once('../src/PhpConsole/__autoload.php');
// if ( !isset($_SESSION) ) session_start();
// PhpConsole\Helper::register();
// PC::DEV_MODE('true');

// MailChimp API keys and List ID
$apiKey = {your-mailchimp-api-key}; // API Key
$listId = {your-mailchimp-list-id}; // List ID

// declare vars
$data = [];
$error = '<p class="error">There was an error, please try again.</p>';
$isPending = 'false';

// check the honeypot to prevent spam signups
if (
   isset($_POST['4ccd4e352a86a182272815b3b']) &&
   $_POST['4ccd4e352a86a182272815b3b'] != ''
)
echo $error; // get out of here!

// check if fields are set
if (
   isset($_POST['FNAME']) &&
   isset($_POST['LNAME']) &&
   isset($_POST['EMAIL']) &&
   isset($_POST['PHONE'])
)
// fill data with fields
$data = [
   'FNAME' => $_POST['FNAME'],
   'LNAME' => $_POST['LNAME'],
   'EMAIL' => $_POST['EMAIL'],
   'PHONE' => implode('-',$_POST['PHONE'])
];
// or else return error
else echo $error;
// PC::data($data);

// finally, add to list
$response = addToList($apiKey, $listId, $data);
// PC::response($response);
if ($response['httpCode'] == 200) $isPending = 'true';
// PC::isPending($isPending);

// echo the response
echo $isPending;

function addToList($apiKey, $listId, $data) {

   $memberId      =  md5(strtolower($data['EMAIL']));
   $dataCenter    =  substr($apiKey,strpos($apiKey,'-')+1);
   $url           =  'https://' . $dataCenter .
                     '.api.mailchimp.com/3.0/lists/' . $listId .
                     '/members/' . $memberId;

   $json = json_encode([
      'email_address'   => $data['EMAIL'],
      'merge_fields'    => [
         'FNAME'        => $data['FNAME'],
         'LNAME'        => $data['LNAME'],
         'PHONE'        => $data['PHONE']
      ],
      'status'          => 'pending'
   ]);

   $ch = curl_init($url);

   curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
   curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 10);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

   $response['result'] = json_decode(curl_exec($ch));
   $response['httpCode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);

   return $response;

}

?>
