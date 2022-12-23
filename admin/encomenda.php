
    <?php
session_start();
include("../db.php");

error_reporting(0);
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete')
{
$order_pro_id=$_GET['Id'];

/*this is delet query*/
mysqli_query($con,"delete from order_products where order_pro_id='$order_pro_id'")or die("delete query is incorrect...");
} 

///pagination
$page=$_GET['page'];

if($page=="" || $page=="1")
{
$page1=0;	
}
else
{
$page1=($page*10)-10;	
}

include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Encomendas<?php echo $page;?> </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table table-hover tablesorter " id="">
                    <thead class=" text-primary">
                      <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Telefone</th>
                    </tr></thead>
                    <tbody>
                      <?php 
                      $query = 
                      "
                      select order_products.order_pro_id Id, products.product_title Produto, order_products.qty Quantidade, order_products.amt Preço, categories.cat_title Categoria,
                      orders_info.f_name Cliente, orders_info.email Email, orders_info.address Endereço, orders_info.city Cidade, user_info.mobile Telefone
                      from order_products 
                      inner join products on order_products.product_id = products.product_id
                      inner join orders_info on order_products.order_id = orders_info.order_id
                      inner join user_info on user_info.user_id = orders_info.user_id
                      inner join categories on categories.cat_id = products.product_cat order by Id desc

                      ";
                        $result=mysqli_query($con,"$query Limit $page1,10")or die ("query 1 incorrect.....");
                      
                        while(list($Id,$Produto,$Quantidade,$Preço,$Categoria,$Cliente,$Email,$Endereço,$Cidade,$Telefone)=mysqli_fetch_array($result))
                        {	
                        echo "
                        <tr>

                            <td>$Produto</td>
                            <td>$Quantidade</td>
                            <td>$Preço</td>
                            <td>$Categoria</td>
                            <td>$Cliente</td>
                            <td>$Email</td>
                            <td>$Endereço</td>
                            <td>$Cidade</td>
                            <td>$Telefone</td>

                            <td>
                            <a class=' btn btn-danger' href='encomenda.php?Id=$Id&action=delete'>ELIMINAR</a>
                            </td>

                        </tr>";
                        }
                        ?>
                    </tbody>
                  </table>
                  
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <?php
include "footer.php";
?>