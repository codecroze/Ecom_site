<?php require_once("../resources/config.php"); ?>
<?php include 'user_login.php'; ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php 



	process_transaction();

	//session_destroy();



?>

    <!-- Page Content -->
    <div class="container">

<h1 class="text-center">Thank You</h1>



 </div><!--Main Content-->


           <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
