<?php
$myfile = file_get_contents("token.json");
$token_obj = json_decode($myfile, true);
$access_token = "";
$refresh_token = $token_obj["refresh_token"];
$login_info = array(
	"email"=>"ots@quychan.com",
	"password"=>"qk6J8nxfL3yaAx7P"
);
// cần tự thêm code để lấy lại acccess token và đăng nhập lại nếp token hết hạn
//
//'https://service.khaiminhthu.com/api/kmt/full'
function postRequest($url, $header, $body)
{
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
    // CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
		CURLOPT_HTTPHEADER=> $header, 	
		CURLOPT_POSTFIELDS => $body
	));
	$resp = curl_exec($curl);

	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
// var_dump($resp);
	curl_close($curl);
	return array(
		"status_code" => $httpcode,
		"resp" => $resp
	);
};

function refreshToken($url, $refresh_token)
{

	$curl = curl_init($url.$refresh_token);
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		// CURLOPT_URL => ,
		CURLOPT_CUSTOMREQUEST => "PUT",
    // CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL	
	));
	$resp = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	return array(
		"status_code" => $httpcode,
		"resp" => $resp
	);
};
function login($url, $body)
{

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $body
    // CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL	
	));
	$resp = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	return array(
		"status_code" => $httpcode,
		"resp" => $resp
	);	
};

$url = 'https://service.khaiminhthu.com/api/kmt/full';
$authorization = "Authorization: Bearer ".$access_token;
$header = array($authorization);

$body_data_mock = array(
	"email"=>"abcxyz@gmail.com",
	"phone"=>"0548973152",
	"first_name"=>"phạm",
	"last_name"=>"an",
	"middle_name"=>"thị thuỳ",
	"calendar"=>0, 
	"gender"=>0,
	"day"=>6,
	"month"=>5,
	"year"=>2016,
	"hour"=>4,
	"minute"=>2
);

echo("https://service.khaiminhthu.com/api/auth/token/refresh/".$refresh_token);
$res = refreshToken("https://service.khaiminhthu.com/api/auth/token/refresh/", $refresh_token);
var_dump(json_decode($res["resp"]));
?>