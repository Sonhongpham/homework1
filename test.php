
<?php
include_once "index.php";

$myfile = file_get_contents("token.json");
$token_obj = json_decode($myfile, true);
$access_token = $token_obj["access_token"];
$refresh_token = $token_obj["refresh_token"];
$login_info = array(
	"email"=>"ots@quychan.com",
	"password"=>"qk6J8nxfL3yaAx7P"
);
//
//'https://service.khaiminhthu.com/api/kmt/full'
function postRequest($url,$access_token, $body)
{
	$authorization = "Authorization: Bearer ".$access_token;
	$header = array($authorization);
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
}

function refreshToken($url, $refresh_token)
{
	$curl = curl_init($url.$refresh_token);
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_CUSTOMREQUEST => "PUT",
    // CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL	
	));
	$resp = curl_exec($curl);
	// $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	return json_decode($resp);
}
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
	// $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	return json_decode($resp);
};

//link để call API
$url = 'https://service.khaiminhthu.com/api/kmt/gift';
	
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$middle_name = $_POST['middle_name'];
$calendar = $_POST['calendar'];
$gender = $_POST['gender'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$hour = $_POST['hour'];
$minute = $_POST['minute'];

$_POST = array(
	"email"=>"abc@gmail.com",
	"phone"=>"0548973152",
	"first_name"=>"$first_name",
	"last_name"=>"$last_name",
	"middle_name"=>"$middle_name",
	"calendar"=>$calendar, 
	"gender"=>$gender,
	"day"=>$day,
	"month"=>$month,
	"year"=>$year,
	"hour"=>$hour,
	"minute"=>$minute
);

if (isset($_POST) & !empty($_POST)) {
	// echo $_POST["tendem"];
	$res = postRequest($url,$access_token, $_POST); 
	if($res["status_code"] == "500")
	{
		$new_token_res= refreshToken("https://service.khaiminhthu.com/api/auth/token/refresh/", $refresh_token);
		if($new_token_res->status == "500")
		{
			// đăng nhập lại = ))
			
			$new_token_res = login("https://service.khaiminhthu.com/api/auth/login", $login_info);

		};
		// var_dump($new_token_res["resp"]);
		$data = $new_token_res->data;
		// var_dump($new_token_res["resp"]);
		$access_token = $data->access_token;
		$refresh_token = $data->refresh_token;
		$json_file = fopen('token.json', 'w');
		fwrite($json_file, json_encode($data));
		$res = postRequest($url,$access_token, $_POST);
	};
	$data_response = json_decode($res["resp"]);

	//đây là link trả về, làm sao trả vể ajax anh tự nghĩ nhé :))
	echo $data_response->data;

}
else echo "500";
?>