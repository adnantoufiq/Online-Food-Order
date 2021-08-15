<?php include('partials/menu.php');?>

        <div class = "Main-Content">
                <div class="wrapper">
                  <h1>Manage Admin</h1>  
                
                </br>

                        <?php
                            if(isset($_SESSION['add']))
                            {
                                    echo $_SESSION['add'];   // display add admin message//
                                    unset ($_SESSION['add']); //removing session messeage//
                            }

                            if(isset($_SESSION['delete']))
                            {
                                    echo $_SESSION['delete']; // dispaly delete admin message
                                    unset ($_SESSION['delete']); //removing session message
                            }

                            if(isset($_SESSION['update']))
                            {
                                    echo $_SESSION['update'];
                                    unset ($_SESSION['update']);
                            }

                            
                            if(isset($_SESSION['user-not-found']))
                            {
                                    echo $_SESSION['user-not-found'];
                                    unset ($_SESSION['user-not-found']);
                            }

                            if(isset($_SESSION['pwd-not-found']))
                            {
                                    echo $_SESSION['pwd-not-found'];
                                    unset ($_SESSION['pwd-not-found']);
                            }
                            if(isset($_SESSION['change-pwd']))
                            {
                                    echo $_SESSION['change-pwd'];
                                    unset ($_SESSION['change-pwd']);
                            }

                        ?>
                        </br>
                        </br>
                        </br>
                        
                        <!-- Button to add Admin -->
                         <a href="add-admin.php" class="btn-primary"> Add Admin</a>
                
                </br>      
                        </br>            
                         <table class="tbl-full">

                                <tr>
                                   <th> S.N</th>
                                   <th>Full Name</th>
                                   <th>User Name</th>
                                   <th> Actions</th>
                                        
                                </tr>

                            <?php
                                $sql="SELECT * FROM tbl_admin";

                                //exicute the query//
                               $res=mysqli_query($conn,$sql);
                                // check wheter the query is exicute or not

                                $sn=1; //create a variable to assign while
                                
                                if($res==TRUE)
                                { 
                                        $count= mysqli_num_rows($res);//function to get all the row in database

                                        //check the number of rows
                                        if($count>0)
                                        {
                                                //we have data in database
                                                while($rows=mysqli_fetch_assoc($res))
                                                {

                                                        $id=$rows['id'];
                                                        $full_name=$rows['Full_Name'];
                                                        $user_name=$rows['User_Name'];

                                                //display the values in our table

                                                ?>

                                                <tr>
                                                        <td><?php echo $sn++;?></td>
                                                        <td><?php echo $full_name;?> </td>
                                                        <td><?php echo $user_name;?></td>
                                                        
                                                        <td>
                                                                <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                                                <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>

                                                                <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-normal">Delete Admin</a>
                                                        </td>   
                                                </tr>
                                                        
                                                        
                                                <?php
                                                }
                                        }
                                        else
                                        {
                                                // data not in database
                                        }
                                }
                            
                            
                            
                            ?>








                        </table>
                

                             
                </div>
            
        </div>
    
<?php include('partials/footer.php');?>