<?php require_once("../../resources/config.php");

//if we get and id from GET requests:
if(isset($_GET['delete_slide_id'])){

	$query_del = query("SELECT slide_image FROM slides WHERE slide_id = ".escape_string($_GET['delete_slide_id']) ." ");
  
     confirm($query_del);

     $row = fetch_array($query_del);

     $target_path = UPLOAD_DIRECTORY . DS . $row['slide_image'];

     unlink($target_path);//to delete the image file in the system or server




	$query = query("DELETE FROM slides WHERE slide_id = ".escape_string($_GET['delete_slide_id']) ." ");
	
	confirm($query);

	
	set_message("Slide ".escape_string($_GET['delete_slide_id'])." deleted");

	redirect("index.php?slides");



}




?>