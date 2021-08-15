<?php
        // include constants file

        include('../config/constants.php');

        // get the admin id to delet


         $id=$_GET['id'];

        // create sql query

        $sql= "DELETE FROM tbl_admin WHERE id=$id";

        

        // exicute the query
        $res= mysqli_query($conn,$sql);

        // check wheteher the query is exicute
        if($res==TRUE)
        {

            //admin deleted succesfully
            // echo"Admin deleted successfully";
            // create session vairable to display message
            $_SESSION['delete']="<div class='right'>Admin deleted successfully</div>";
            // redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');


        }
        else
        {
           // echo"not deleted";
           $_SESSION['delete']="<div class='error'>Failed to delete , Try again latter</div>";
           header('location:'.SITEURL.'admin/manage-admin.php');
        }

        // redirect to manage admin page with message(sucess/error)




        



?>
