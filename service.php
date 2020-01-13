<?php
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

require_once('connect.php');

/*
Number description:
1.show my stocks data
2.all stocks (updating)
3.buy (tell alkesh to show balance on the navbar itself so one can play with it there itself)
4.sell 
// in case of  buy and sell just update the balance of the user
5.
6.
*/




if (isset($_GET['number']) && isset($_GET['user_name']))
{
$number=$_GET['number'];
$user_name=$_GET['user_name'];
//echo $number.$user_name;
switch ($number) {
    case 1:
	    	$query="select distinct stock_name,purchased_price,quantity from user_stocks where user_name='".$user_name."';";
		$result=mysqli_query($con,$query);
		$json_array=array();
		if (mysqli_num_rows($result)>0)
		{
		while ($row = mysqli_fetch_assoc($result))
		{
		// call zack to get current value of the stock	
		////// complete this line
		//////////////
		//this url gets current value of a particular stock
		
		
		//$url="http://3.135.147.14/realtime?symbol=".$row['stock_name'];
		$current_value=12;//file_get_contents($url);
		$row += ["current_value" => $current_value];
		$json_array[]=$row;
		}
		print(json_encode($json_array));
		}
		mysqli_close($con);
    		break;    
    case 2:
        //show all available stocks
        
        //tell zack to periodically update this database
		$query="select * from stock_info;";
		$res=mysqli_query($con,$query);
		$json_array=array();
		if (mysqli_num_rows($res)>0)
		{
		while ($row = mysqli_fetch_assoc($res))
		{
		$json_array[]=$row;
		}
		print(json_encode($json_array));
		}
		mysqli_close($con);
		break;
   
    case 3:
    	//buying 
    	// req= new_balance,stock_name,purchased_price,quantity
    	if (isset($_GET['new_balance']) && isset($_GET['stock_name'])&& isset($_GET['quantity']) && isset($_GET['pur_price']))
    {//1
    
    
    
    /*
    		$query="select quantity from user_stocks where user_name='".$_GET['user_name']."' and stock_name='".$_GET['stock_name']."';";
	    	$result=mysqli_query($con,$query);
		$row = mysqli_fetch_assoc($result);
		$quantity=(int)$row['quantity'];
		echo $quantity;
		$d=(int)$_GET['quantity'];
	    	$quantity=$quantity-$d;
	    	
    */
    
    
    
    
    
    	$quantity=(int)$_GET['quantity'];
    	$stock_name=$_GET['stock_name'];
	$pur_price=(int)$_GET['pur_price'];
    	$query="select * from user_stocks where user_name='".$_GET['user_name']."' and stock_name='".$_GET['stock_name']."';";
    	echo $query;
    	$r=mysqli_query($con,$query);
        $number = mysqli_num_rows($r);
       
        
    
    	//stock present or not
    	if($number > 0)
    	{//2
    	 $q=mysqli_query($con,$query);
	  //  $quantity=(int)$r;
	  $row = $q -> fetch_assoc();
              $prev= $row["quantity"];
	    $quantity=$prev+$quantity;
	    $queryy="update user SET balance='".$_GET['new_balance']."' WHERE user_name='".$_GET['user_name']."';";
	    echo $queryy;  		
	    echo "\n gg";
	    $re=mysqli_query($con,$queryy);
	    echo $re;
		if($re)
		{//4				
		$query="update user_stocks SET quantity='".$quantity."' WHERE user_name='".$_GET['user_name']."' and stock_name='".$stock_name."';";
		$rRes=mysqli_query($con,$query);
		if($rRes)
		{//5
		//add it to user_stock table
		$stock_name=$_GET['stock_name'];
		$pur_price=$_GET['pur_price'];
		
		$query="update user_stocks SET purchased_price='".$pur_price."' WHERE user_name='".$_GET['user_name']."' and stock_name='".$stock_name."';";
	    	$res=mysqli_query($con,$query);
	
		if($res)
	    	{
	    	echo "Success";break;	
	    	}
		
	    	else{echo "Stock already exists";break;}
		
		}//5
		else{echo "Error3";break;}
		}//4

	}
	
	$query="insert into user_stocks(user_name,stock_name,purchased_price,quantity) values('".$user_name."','".$stock_name."','".$pur_price."','".$quantity."')";
    	echo $query;
	$res=mysqli_query($con,$query);	
	$queryy="update user SET balance='".$_GET['new_balance']."' WHERE user_name='".$_GET['user_name']."';";
	$re=mysqli_query($con,$queryy);
	//stock present then   

//	   
		
		
}//1
	
	break;
	


  
    case 4:
    	//selling new balance quantity user_name stock name
    	// all balance validation should be done on alkesh's side first 
    	if (isset($_GET['new_balance']) && isset($_GET['quantity']))
    	{
    		echo $_GET['new_balance'];
	    	$query="select quantity from user_stocks where user_name='".$_GET['user_name']."' and stock_name='".$_GET['stock_name']."';";
	    	$result=mysqli_query($con,$query);
		$row = mysqli_fetch_assoc($result);
		$quantity=(int)$row['quantity'];
		echo $quantity;
		$d=(int)$_GET['quantity'];
	    	$quantity=((int)$row['quantity'])-$d;
	    	
	    	echo "Quantity Now-".$query;
	    	
		$queryy="update user set balance='".$_GET['new_balance']."' where user_name='".$_GET['user_name']."';";
		echo $query;
	    	$res=mysqli_query($con,$queryy);
	    	echo $quantity;
	    	
		if($res)
		{//2.
		
		
		if($quantity<1)
		{//0
		
		
			$query="delete from user_stocks where stock_name='".$_GET['stock_name']."' and user_name='".$user_name."';";
			$rRes=mysqli_query($con,$query);
			if($rRes)
			{
			
			echo "Success";break;
			}
			
			else{echo "Error1";break;}
			
			
		}
		
		$query="update user_stocks set quantity='".$quantity."' where stock_name='".$_GET['stock_name']."' and user_name='".$user_name."';";
		$rRes=mysqli_query($con,$query);
		
		if($rRes)
		{
		
			echo "Success";break;
		
		}
		else
		{
			echo "Error2";break;
		}
		}//2.
	else
	{echo "Error2";break;}
	
	}
	
	else
	{
	echo "Sorry Cannot complete this process";break;
	}
	
    default:
        echo "Default";


}

}
else{
echo "Error end";
}
?>