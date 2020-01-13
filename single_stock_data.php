<?php

//to do check for the date format
if(isset($_POST['single_stock_data']))
{

$stock_name=$_POST['stock_name'];
require_once('connect.php');

//stock_name
if (isset( $stock_name))
{
$query="select * from stock_info where stock_name='".$stock_name."';";
$res=mysqli_query($con,$query);

$json_array=array();
if (mysql_num_rows($result)>0)
{
while ($row = mysql_fetch_assoc($res))
{
//stock_name	open	high	low	close	volume	date
//echo //"stock_name=".$row['stock_name']."#open=".$row['open']."#close=".$row['close'].."#high=".$row['high']."#low=".$row['low']."#open="//.$row['open']."#volume=".$row['volume']."#date=".$row['date'];
$json_array[]=$row;


}

print(json_encode($json_array));
mysqli_close($con);

}


?>