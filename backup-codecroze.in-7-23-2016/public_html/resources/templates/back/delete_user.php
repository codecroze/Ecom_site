<?php require_once("../../../../resources/config.php");

//if we get and id from GET requests:
if(isset($_GET['id'])){

	$query = query("DELETE FROM user WHERE user_id = ".escape_string($_GET['id']) ." ");
	
	confirm($query);

	set_message("User ".escape_string($_GET['id'])." deleted");

	redirect("../../../admin/index.php?users");



}else{
		redirect("../../../admin/index.php?users");

}




?>