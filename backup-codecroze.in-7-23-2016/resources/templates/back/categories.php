       
<?php 


add_categories();


?>
<h3 class="bg-success"><?php display_message(); ?></h3><h1 class="page-header">
  Product Categories

</h1>


<div class="col-md-4">
    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category_title" >Title</label>
                    <input name="category_title" type="text" class="form-control">

        </div>

        <div class="form-group">
            
            <input name="add_category" type="submit" class="btn btn-primary" value="Add Category">
        </div>      


    </form>


</div>
<div class="row">

<div class="col-md-8">

    <table class="table table-hover">
            <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
        </tr>
            </thead>


    <tbody>
       
           <?php show_categories();?>
        
    </tbody>

        </table>
    </div>

</div>



                













            </div>
            <!-- /.container-fluid -->

