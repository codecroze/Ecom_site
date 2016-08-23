<?php

//ob_start();//buffering sends requests to php

session_start();
//ssion_destroy();

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); //if defined then process NULL else make it defined

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT" , __DIR__ .DS. "templates/front"); //if defined then process NULL else make it defined

defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK" , __DIR__ .DS. "templates/back"); //if defined then process NULL else make it 

defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY" , __DIR__ .DS. "uploads"); //for uploaded image or other files


defined("DB_HOST") ? null : define("DB_HOST" , "localhost"); //if defined then process NULL else make it defined

defined("DB_USER") ? null : define("DB_USER" ,  "root"); //if defined then process NULL else make it defined

defined("DB_PASS") ? null : define("DB_PASS" ,  ""); //if defined then process NULL else make it defined

defined("DB_NAME") ? null : define("DB_NAME" , "ecom_db"); //if defined then process NULL else make it defined

//echo TEMPLATE_FRONT;//path of file

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);



require_once("functions.php");

require_once("cart.php");

?> 