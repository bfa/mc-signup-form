<?php
/*
Script:        AJAX Processing to Check Subscription Status For User
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
$status = 'false';

// check if fields are set
if ( isset($_POST['EMAIL']) ) $data = [ 'EMAIL' => $_POST['EMAIL'] ];
// or else return error
else echo $error;
// PC::data($data);

// finally, check subscription status
$response = checkSubscriptionStatus($apiKey, $listId, $data);
// PC::response($response);
$result = $response['result'];
if ($response['httpCode'] == 200) $status = $response['result']->status;
// PC::status($status);

// echo the response
echo $status;

function checkSubscriptionStatus($apiKey, $listId, $data) {

   $response = [];

   $memberId = md5(strtolower($data['EMAIL']));
   $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
   $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

   $json = json_encode([
      'email_address' => $data['EMAIL']
   ]);

   $ch = curl_init($url);

   curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
   curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 10);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

   $response['result'] = json_decode(curl_exec($ch));
   $response['httpCode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);

   return $response;

}

?>
