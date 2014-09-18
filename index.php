<?php
header('Content-type: application/json');
date_default_timezone_set('Europe/Zurich');

function get_http_headers() { 
  $headers = ''; 
  foreach ($_SERVER as $name => $value) { 
    if (substr($name, 0, 5) == 'HTTP_') { 
      $headers[lcfirst(str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))))] = $value; 
    } 
  } 
  return $headers; 
} 

$output = array();
//$output['status'] = $_SERVER['REDIRECT_STATUS'];
$output['http'] = get_http_headers();
if (!empty($_SERVER['REQUEST_METHOD'])) {
  $output['http']['method'] = $_SERVER['REQUEST_METHOD'];
}
if (!empty($_SERVER['CONTENT_TYPE'])) {
  $output['http']['contentType'] = $_SERVER['CONTENT_TYPE'];
}
if (!empty($_SERVER['CONTENT_LENGTH'])) {
  $output['http']['contentLength'] = $_SERVER['CONTENT_LENGTH'];
}
if (!empty($_SERVER['SERVER_PROTOCOL'])) {
  $output['http']['protocol'] = $_SERVER['SERVER_PROTOCOL'];
}
if (!empty($_SERVER['REMOTE_ADDRESS'])) {
  $output['http']['ip'] = $_SERVER['REMOTE_ADDRESS'];
}
if (sizeof($_FILES)) {
  $output['data']['files'] = $_FILES;
}
if (sizeof($_POST)) {
  $output['data']['post'] = $_POST;
}
if (sizeof($_GET)) {
  $output['data']['get'] = $_GET;
}
$stream = @file_get_contents('php://input');
if ($stream != '') {
  $output['data']['raw'] = $stream;
}
$json = json_decode($stream);
if (is_object($json)) {
  $output['data']['json'] = $json;
}

if (!empty($_SERVER['REQUEST_TIME'])) {
  $output['requestTime'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
}
echo json_encode($output);
?>