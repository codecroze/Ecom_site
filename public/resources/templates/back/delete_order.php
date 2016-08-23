<?php require_once("../../config.php");

//if we get and id from GET requests:
if(isset($_GET['id'])){

	$query = query("DELETE FROM orders WHERE order_id = ".escape_string($_GET['id']) ." ");
	
	confirm($query);

	set_message("Order ".escape_string($_GET['id'])." deleted");

	redirect("../../../public/admin/index.php?orders");



}




?>