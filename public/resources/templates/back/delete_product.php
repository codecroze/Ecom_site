<?php require_once("../../config.php");

//if we get and id from GET requests:
if(isset($_GET['id'])){

	$query = query("DELETE FROM products WHERE product_id = ".escape_string($_GET['id']) ." ");
	
	confirm($query);

	set_message("Product ".escape_string($_GET['id'])." deleted");

	redirect("../../../public/admin/index.php?products");



}else{
		redirect("../../../public/admin/index.php?products");

}




?>