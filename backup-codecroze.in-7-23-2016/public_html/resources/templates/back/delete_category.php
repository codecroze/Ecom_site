<?php require_once("../../../../resources/config.php");

//if we get and id from GET requests:
if(isset($_GET['id'])){

	$query = query("DELETE FROM categories WHERE cat_id = ".escape_string($_GET['id']) ." ");
	
	confirm($query);

	set_message("Category ".escape_string($_GET['id'])." deleted");

	redirect("../../../admin/index.php?categories");



}else{
		redirect("../../../admin/index.php?categories");

}




?>