<?php require_once("../../config.php");

//if we get and id from GET requests:
if(isset($_GET['id'])){

	$query = query("DELETE FROM reports WHERE report_id = ".escape_string($_GET['id']) ." ");
	
	confirm($query);

	set_message("Report ".escape_string($_GET['id'])." deleted");

	redirect("../../../public/admin/index.php?reports");



}else{
		redirect("../../../public/admin/index.php?reports");

}




?>