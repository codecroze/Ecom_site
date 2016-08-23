<?php require_once("../../resources/config.php"); ?>

<?php

function last_id(){ //to find out the last product id
	global $connection;

	return mysqli_insert_id($connection);
}

 if(isset($_GET['add'])){ //for adding products when cart.php?add is clicked 

 	$query = query("SELECT * FROM products WHERE product_id = ". escape_string($_GET['add']) ." ");
 	confirm($query);

 	while($row=fetch_array($query)){

 		if($row['product_quantity']!= $_SESSION['product_'.$_GET['add']]){
 			 $_SESSION['product_'.$_GET['add']]+=1;
 			 redirect('../checkout.php');
 		}

 		else{
 			set_message("We only have ". $row['product_quantity']. " ". "{$row['product_title']}" .  " available");
 			redirect("../checkout.php");
 		}
 	}
 

 //	$_SESSION['product_' . $_GET['add']]+=1;
 //	redirect("index.php");
 }

if(isset($_GET['remove']))//it is for removing the sessions
{
	 $_SESSION['product_'.$_GET['remove']]--;
	 if( $_SESSION['product_'.$_GET['remove']]<1){
	 	
	 	unset($_SESSION['item_total']);

		 unset($_SESSION['item_total_quantity']);
	 	redirect('../checkout.php');
	 }
	 else{
	 	redirect("../checkout.php");
	 }
}

if(isset($_GET['delete'])){
		 

		 $_SESSION['product_'.$_GET['delete']]='0';
		 
		 unset($_SESSION['item_total']);

		 unset($_SESSION['item_total_quantity']);

		 redirect("../checkout.php");

}


function cart(){

	$total =0 ;

	$total_item=0;

	$item_name =1;
	$item_number=1;
	$amount=1;
	$quantity = 1;

	foreach ($_SESSION as $name => $value) {

		if($value > 0){
			if (substr($name, 0,8) == "product_") {

				$length = strlen($name-8);

				$id = substr($name , 8, $length);


					$query = query("SELECT * FROM products WHERE product_id = ". escape_string($id) . " ");
	confirm($query);

	while($row = fetch_array($query)){

		$sub = $row['product_price']*$value;
		 $total_item += $value;

		 $product_image = display_image($row['product_image']);


		$product = <<<DELIMETER

		 <tr>
                <td>{$row['product_title']}<br>
                <img width ='100' src='../resources/{$product_image}'>

                </td>

                
                <td>&#x20B9;{$row['product_price']}</td>
                <td>{$value}</td>
                <td>&#x20B9;{$sub}</td>
  <td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
  <a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a>
  <a class='btn btn-success'  href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a></td>
              
            </tr>


  <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
  <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
  <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
  <input type="hidden" name="quantity_{$quantity}" value="{$value}">


DELIMETER;

 echo $product; 


$item_name ++;
	$item_number++;
	$amount++;
    $quantity++;

	}

$_SESSION['item_total'] = $total += $sub;
$_SESSION['item_total_quantity'] = $total_item ;


}
				


			}
		}


			}

function show_paypal(){

	if(isset($_SESSION['item_total_quantity']) && $_SESSION['item_total_quantity']>=1){

	$paypal_button = <<<DELIMETER

		<input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">

DELIMETER;

return $paypal_button;

}
}


function process_transaction(){

global $connection;

//for getting the order  details 
if(isset($_GET['tx'])){
	$amount = $_GET['amt'];
	$currency = $_GET['cc'];
	$transaction = $_GET['tx'];
	$status = $_GET['st'];





 


	$total =0 ;
	$total_item=0;
//value is the quantity
	foreach ($_SESSION as $name => $value) {

		if($value > 0){
			if (substr($name, 0,8) == "product_") {

				$length = strlen($name-8);

				$id = substr($name , 8, $length);


	$send_order = query("INSERT INTO orders (order_amount,order_transaction,order_status,order_currency) VALUES('{$amount}','{$transaction} ', ' {$status}', '{$currency} ')");
	
	//to give the last inserted id:
	$last_id=last_id();

	confirm($send_order);


					$query = query("SELECT * FROM products WHERE product_id = ". escape_string($id) . " ");
	confirm($query);

	while($row = fetch_array($query)){

		$product_price=$row['product_price'];
		$product_title=$row['product_title'];

		$sub = $row['product_price']*$value;
		 $total_item += $value;


         $insert_report = query("INSERT INTO reports (product_id,product_title,order_id,product_price,product_quantity) VALUES('{$id}','{$product_title} ', '{$last_id} ', '{$product_price} ', ' {$value}')");
	     confirm($insert_report);



	}

 $total += $sub;
 //echo $item_total_quantity;
 //echo $total_item;




}
				


			}
		}

	session_destroy();
	}
else{
	redirect("index.php");
}


			}


			




?>