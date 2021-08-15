<?php include('partials/menu.php')?>

<div class="Main-Content">
    <div class= "wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        
        $id=$_GET['id'];

        $sql="SELECT * FROM tbl_admin WHERE id=$id";

        $res=mysqli_query($conn,$sql);

        if($res==TRUE)
        {

            $count=mysqli_num_rows($res);
            if($count==1)
            {
                $row=mysqli_fetch_assoc($res);

                $full_name=$row['Full_Name'];
                $user_name=$row['User_Name'];

                //echo"admin Avaiable";

            }
            else
            {
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        
        
        
        ?>

      

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="Full_Name" value="<?php echo  $full_name ?>"></td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="User_Name" value="<?php echo $user_name?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">

                    </td>
                </tr>
                
            </table>
        </form>

    </div>


</div>


<?php

if(isset($_POST['submit']))
{
    //echo"button click";

    $id=$_POST['id'];
    $full_name=$_POST['Full_Name'];
    $user_name=$_POST['User_Name'];

    $sql="UPDATE tbl_admin SET
            Full_Name='$full_name',
            User_Name='$user_name'
            WHERE id='$id'" ;


    $res=mysqli_query($conn,$sql);

    if($res==TRUE)
    {
       // $_SESSION=['update'] ="<div class='right'>Admin Updated Successfully.</div>";

        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
       // $_SESSION=['update '] ="<div class='error'>faild to delete Admin.</div>";

        header('location:'.SITEURL.'admin/manage-admin.php');

    }
}



?>


<?php include('partials/footer.php')?>