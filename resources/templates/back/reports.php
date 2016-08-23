

        <div id="page-wrapper">

            <div class="container-fluid">

             <div class="row">

<h1 class="page-header">
   All Reports

</h1>
<h3 class="bg-success"><?php display_message(); ?></h3>

<table class="table table-hover">


    <thead>

      <tr>
          <th>Report ID</th>
           <th>Product ID</th>
           <th>Product title</th>
           <th>Order ID</th>
           <th>Product Price</th>
           <th>Product Quantity</th>
      </tr>
    </thead>
    <tbody>


      <?php get_reports_in_admin();?>


  </tbody>
</table>











                
                 


             </div>

            </div>
            <!-- /.container-fluid -->

