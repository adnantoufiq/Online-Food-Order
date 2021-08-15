<?php include('partials/menu.php');?>

        <div class = "Main-Content">
                <div class="wrapper">
                        
                

                               <h1>Dashboard</h1>
                               <br><br>

                               <?php
            
                                        if(isset($_SESSION['login']))
                                        {
                                                echo $_SESSION['login'];
                                                unset($_SESSION['login']);
                                        }
                                        
                                
                                
                                ?>
                                <br><br> 

                                <div class="col-4 text-center">
                                        <?php
                                        
                                                $sql="SELECT * FROM tbl_category";

                                                $res=mysqli_query($conn,$sql);

                                                $count=mysqli_num_rows($res);
                                        
                                        ?>
                                        <h1><?php echo $count; ?></h1>
                                        Categories
                                </div>

                                <div class="col-4 text-center">
                                        <?php
                                                
                                                $sql2="SELECT * FROM tbl_food";

                                                $res2=mysqli_query($conn,$sql2);

                                                $count2=mysqli_num_rows($res2);
                                        
                                        ?>
                                        <h1><?php echo $count2; ?></h1>
                                        Foods
                                </div>

                                <div class="col-4 text-center">
                                <?php
                                        
                                        $sql3="SELECT * FROM tbl_order";

                                        $res3=mysqli_query($conn,$sql3);

                                        $count3=mysqli_num_rows($res3);
                                
                                ?>
                                        <h1><?php echo $count3; ?></h1>
                                        Total Orders
                                </div>

                                <div class="col-4 text-center">
                                        <?php
                                        
                                                //Create Sql Query to total Revenue Generated
                                                //Aggregate Function in Sql
                                                $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                                                $res4=mysqli_query($conn,$sql4);

                                                //Get the Value
                                                $row4=mysqli_fetch_assoc($res4);
                                                //Get the Total Revenue
                                                $total_revenue=$row4['Total'];
                                        
                                        ?>
                                        <h1>$<?php echo $total_revenue; ?></h1>
                                        Revenue Generated
                                </div>
                                
                                <div class="clear-fix"></div>
                        

                </div>
            
        </div>

<?php include('partials/footer.php') ;?>
      