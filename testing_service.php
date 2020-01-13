<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('connect.php');


if (isset($_GET['user_email']))
{

$email=$_GET['user_email'];

        $query="select stock_name,purchased_price from user_stocks where user_email='".$email."';";
//        $query="select * from user;";// where user_email='".$email."';";
        //echo $query;
        $res=mysqli_query($con,$query);

	$json_array=array();
	//echo mysqli_num_rows($res);
	if (mysqli_num_rows($res)>0)
	{
	while ($row = mysqli_fetch_assoc($res))
	{ 
	// call zack to get current value of the stock	
	////// complete this line
	//////////////
	
	
	$url="http://3.135.147.14/realtime?symbol=".$row['stock_name'];
	$current_value=file_get_contents($url);
	//$current_value=http_get($url);
	
	/*
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://192.168.43.142/realtime?symbol=".$row['stock_name']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	$current_value=curl_exec($ch);
	echo curl_error($ch);
	if($current_value == FALSE){
			die("cURL Error: " . curl_error($ch));
		}
		
	*/
	
	
	
	$row += ["current_value" => $current_value];
	$json_array[]=$row;
	
	}
	print(json_encode($json_array));
	}
	mysqli_close($con);

	
	
}

else
{
echo "Error";
}



echo "hey";


?>?>