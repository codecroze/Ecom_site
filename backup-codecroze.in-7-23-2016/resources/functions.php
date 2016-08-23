<?php
ob_start(); 
$uploads_directory = "uploads";
//helper functions

function set_message($msg){//if user logins incorrectly
    if(!empty($msg)){
        $_SESSION['message']=$msg;
    } else{
        $msg="";
    }

}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

}

function redirect($location){//it will redirect to a location passed as a parameter to function

return	header("Location: $location");
}

function query($sql){//query function
	global $connection;
	return mysqli_query($connection, $sql);
}

function confirm($result){
	global $connection;

	if(!$result){
		die("TimeOUT".msqli_error($connection)); 
	}
}


function escape_string($string){
	global $connection;

	return mysqli_real_escape_string($connection,$string);

}
function fetch_array($result){

	return mysqli_fetch_array($result);
	
}

//front end functions
//function for getting products
function get_products(){
	$query = query("SELECT * FROM products");
	confirm($query);
	while($row = fetch_array($query)){

  $product_image = display_image($row['product_image']);

		$product = <<<DELIMETER

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="resources/{$product_image}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&#x20B9;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" target="_blank" href="resources/cart.php?add={$row['product_id']}">Add to cart</a>
                            
                            </div>

                        </div>
                    </div>
DELIMETER;
echo $product;

	}
}

function get_categories(){
	    $query = query("SELECT * FROM categories");
        
        confirm($query);

                    while($row = fetch_array($query)){
                    	$categories_links = <<<DELIMETER
                     <a href='category.php?id={$row['cat_id']}'' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
echo $categories_links;

                    }
                }


function getproducts_in_cat_page(){
	$query = query("SELECT * FROM products WHERE product_category_id = ". escape_string($_GET['id'])." ");
        
        confirm($query);

                    while($row = fetch_array($query)){
                        $product_image = display_image($row['product_image']);

                    	$product_details = <<<DELIMETER
                                 <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['product_shortdesc']}.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
echo $product_details;
}
}


function getproducts_in_shop_page(){
	$query = query("SELECT * FROM products  ");
        
        confirm($query);

                    while($row = fetch_array($query)){

                        $product_image = display_image($row['product_image']);

                    	$product_details = <<<DELIMETER
                                 <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['product_shortdesc']}.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
DELIMETER;
echo $product_details;
}
}

function login_user(){
	if(isset($_POST['submit'])){
		$username=escape_string($_POST['username']);
		$password=escape_string($_POST['password']);
	    $query= query("SELECT * FROM user WHERE username = '{$username}' AND password= '{$password}' ");
	    confirm($query);

	    if(mysqli_num_rows($query)==0){
            set_message("Wrong username/password");
	    	redirect("login.php");
	    }
	    else{

            $_SESSION['username'] = $username;
	    	redirect("admin");
	    }
	}

}

function send_message(){
if(isset($_POST['submit'])){

   $to = "some@gmail.com";
   $from_name = $_POST['name'];
   $subject = $_POST['subject'];
   $email = $_POST['email'];
   $message = $_POST['message'];
    
   $headers = "From: {$from_name} {$email}";
   $result=mail($to, $subject, $message, $headers );
   if(!$result){
    echo("error");
   }
   else{
    echo ("sent");
   }

}
}



//Back end functions

function display_orders(){

    $query = query( "SELECT * FROM orders ");
    confirm($query);
    while($row = fetch_array($query)){

        $orders = <<<DELIMETER



      <tr>
           <th>{$row['order_id']}</th>
           <th>{$row['order_amount']}</th>
           <th>{$row['order_transaction']}</th>
           <th>{$row['order_currency']}</th>
           <th>{$row['order_status']}</th>
           <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
      </tr>

DELIMETER;


echo $orders;

    }


}

//admin products page

function display_image($picture){//for displaying images in all areas

global $uploads_directory; //defined on top $uploads = "uploads"

return $uploads_directory . DS . $picture;
}

function get_products_in_admin(){



        $query = query("SELECT * FROM products");

    confirm($query);
    while($row = fetch_array($query)){
      $category = show_product_category_title($row['product_category_id']);
      $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER

                          <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']} <br>
             <a href="index.php?edit_product&id={$row['product_id']}" ><img width="100" src="../../resources/{$product_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
DELIMETER;
echo $product;
    }

}


function show_product_category_title($product_category_id){

$category_query = query("SELECT * FROM categories WHERE cat_id = {$product_category_id}");

confirm($category_query);

while($category_row = fetch_array($category_query)){
  return $category_row['cat_title'];
}

}

//add products in admin

function add_product(){

if(isset($_POST['publish'])){
    $product_title = escape_string($_POST['product_title']);
    $product_category_id = escape_string($_POST['product_category_id']);
    $product_price = escape_string($_POST['product_price']);
    $product_description = escape_string($_POST['product_description']);    
    $product_shortdesc = escape_string($_POST['product_shortdesc']);
    $product_quantity = escape_string($_POST['product_quantity']);
    $product_image = escape_string($_FILES['file']['name'] );  //for image file
    $image_temp_location = escape_string($_FILES['file']['tmp_name'] );  


    move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

     if(empty($product_title) || $product_title == ""){
    echo "<p class='bg-danger'>Plz add product title</p>";
  }
  else{

    $query = query("INSERT INTO products(product_title, product_category_id, product_price,product_description,product_shortdesc,product_quantity,product_image)
     VALUES ('{$product_title}', '{$product_category_id} ','{$product_price} ', '{$product_description} ', '{$product_shortdesc}', '{$product_quantity} ','{$product_image} ' )");
     $last_id = last_id();// the function is in cart.php
     
     confirm($query);
     set_message("New product with id {$last_id} just added");
     redirect("index.php?products");

    
  }


}
}

function show_categories_add_product_page(){
      $query = query("SELECT * FROM categories");
        
        confirm($query);

                    while($row = fetch_array($query)){
                      $categories_options = <<<DELIMETER
                      <option value="{$row['cat_id']}"> {$row['cat_title']}</option>
DELIMETER;
echo $categories_options;

                    }
                }

//edit products in admin

function update_product(){

if(isset($_POST['update'])){
    $product_title = escape_string($_POST['product_title']);
    $product_category_id = escape_string($_POST['product_category_id']);
    $product_price = escape_string($_POST['product_price']);
    $product_description = escape_string($_POST['product_description']);    
    $product_shortdesc = escape_string($_POST['product_shortdesc']);
    $product_quantity = escape_string($_POST['product_quantity']);
    $product_image = escape_string($_FILES['file']['name'] );  //for image file
    $image_temp_location = escape_string($_FILES['file']['tmp_name'] );  



    if(empty($product_image)){
      $get_pic = query("SELECT product_image FROM products WHERE  product_id=". escape_string($_GET['id'])." ");
        confirm($get_pic);

        while($row = fetch_array($get_pic)){
          $product_image = $row['product_image'];
        }
    }


    move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

    $query = "UPDATE products SET ";

    $query .= "product_title                      = '{$product_title} '            , ";
    $query .= "product_category_id                = '{$product_category_id} '      , ";
    $query .= "product_price                      = '{$product_price} '            , ";
    $query .= "product_description                = '{$product_description} '      , ";
    $query .= "product_shortdesc                  = '{$product_shortdesc} '        , ";
    $query .= "product_quantity                   = '{$product_quantity} '         , ";
    $query .= "product_image                      = '{$product_image} '              ";
     
     $query .= "WHERE product_id=" . escape_string($_GET['id']); //the id is coming from url bar 
     $send_update_query = query($query);
     confirm($send_update_query);
     set_message(" Product just updated");
     redirect("index.php?products");
   
    
  }



}

//for categories page in admin
function show_categories(){
  $query = query("SELECT * FROM categories");
confirm($query);

 while($row = fetch_array($query)){



$show_cat = <<<DELIMETER
<tr>
                       <td>{$row['cat_id']}</td>
                       <td>{$row['cat_title']}</td>
                       <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
<br></tr>
DELIMETER;
 echo $show_cat;

  }
}

//in admin

function add_categories(){

  if(isset($_POST['add_category'])){




  $category_title = escape_string($_POST['category_title']);

  if(empty($category_title) || $category_title == ""){
    echo "<p class='bg-danger'>Plz add category</p>";
  }
  else{
  $query = query("INSERT INTO categories(cat_title) VALUES('{$category_title}')");

  confirm($query);

  //$last_id = last_id();

  set_message("New category just added");

 

  
   }
}

}



//admin users page

function show_users(){


        $query = query("SELECT * FROM user");
        
        confirm($query);

                    while($row = fetch_array($query)){

                      $user_id = $row['user_id'];
                      $username = $row['username'];
                      $email = $row['email'];
                      $password = $row['password'];

                      $user = <<<DELIMETER


                      <tr>
                      <td>{$user_id}</td>
                      <td>{$username}</td>
                      <td>{$email}</td>
                      <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
                      <br>
                      </tr>
                      
DELIMETER;
echo $user;

                    }
                }


//to add users in admin
function add_user(){

  if(isset($_POST['add_user'])){




  $username = escape_string($_POST['username']);
  $email = escape_string($_POST['email']);
  $password = escape_string($_POST['password']);
  $user_photo = escape_string($_FILES['file']['name'] );  //for image file
  $photo_location = escape_string($_FILES['file']['tmp_name'] );


    move_uploaded_file($photo_location, UPLOAD_DIRECTORY . DS . $user_photo);
     if(empty($username) || $username == ""){
    echo "<p class='bg-danger'>Plz add Username</p>";
  }
  else{

  $query = query("INSERT INTO user (username, email, password ,user_photo) VALUES ('{$username}', '{$email}','{$password}','{$user_photo}' )");

  confirm($query);

  $last_id = last_id();

  set_message("New user with id $last_id just added");

 }

  
   }
}

//to display reports in admin

function get_reports_in_admin(){


        $query = query("SELECT * FROM reports");

    confirm($query);
    while($row = fetch_array($query)){
        $report = <<<DELIMETER

                          <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']} <br>
            </td>
            <td>{$row['product_title']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
DELIMETER;
echo $report;
    }

}






?>