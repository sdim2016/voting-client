<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$username = $_GET["username"];
$password = $_GET["password"];

$url1 = 'https://moodle.xamk.fi/?lang=en';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEFILE, "shib-cookie");
curl_setopt($ch, CURLOPT_COOKIEJAR, "shib-cookie");
curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());

$server_output = curl_exec($ch);
//curl_close($ch);

$logintoken = get_string_between($server_output, '<input type="hidden" name="logintoken" value="', '"/><input class="btn xamk-login-button"');

//echo $logintoken;

$url2 = "https://moodle.xamk.fi/login/index.php";
//$ch = curl_init();
//The data you want to send via POST
$fields = array(
    'username'      => $username,
    'logintoken' => $logintoken,
    'password'         => $password,
    'login'     =>  'Kirjaudu'
);

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url2);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);

curl_close($ch);

//echo $result;

if(strpos($result, 'Invalid login, please try again') !== false) {
  echo "Invalid login or password";
} else {
  echo get_string_between($result, '<span class="userbutton"><span class="usertext">', '</span><span class="avatars">');
}

 ?>
