<?PHP
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

require_once('connect.php');



if (isset($_GET['user_name']))
{
$user_name=$_GET['user_name'];

$query="select balance from user where user_name='".$user_name."';";
		$result=mysqli_query($con,$query);
if($result){
		$row = mysqli_fetch_assoc($result);
		$json_array=array();
		if (mysqli_num_rows($result)>0)
		{
		$json_array[]=$row;
		print($row['balance']);
/*		
				$encoded = "...";   // <-- encoded string from the request
$decoded = "";
for( $i = 0; $i < strlen($encoded); $i++ ) {
    $b = ord($encoded[$i]);
    $a = $b ^ 123;  // <-- must be same number used to encode the character
    $decoded .= chr($a)
}
echo $decoded;
*/
		//print(json_encode($json_array));
		}
		else{
		echo "NOT FOUND";
		}
		

}
else{
echo "Username not found";
}

}

else{
	
	echo "Bad Input";

}

?>