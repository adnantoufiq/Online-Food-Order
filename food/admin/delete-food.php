<?php

    include('../config/constants.php');

    //echo'delte food';

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //echo"procws to delete";
        

        //1.get id and image

        $id=$_GET['id'];
        $image_name=$_GET['image_name'];
        //2.remoove the image if available
        
        if($image_name!="")
        {
            $path="../images/food/".$image_name;

            $remove=unlink($path);

            if($remove==false)
            {
                $_SESSION['upload']="<div class ='error'> Failed Remove Image File.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');

                die();


            }
           
        }
        //3. delte food from database

        $sql="DELETE FROM tbl_food where id=$id";

        $res=mysqli_query($conn,$sql);

        if($res==true)
        {
            $_SESSION['delete']="<div class ='success'> Food Deleted Sucessfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }
        else
        {
            $_SESSION['delete']="<div class ='error'>Failed To Delete Succesfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');

        }
        //4.redirect to  manage food with sessrion messagw

    }
    else
    {
        //echo"redirect";
        $_SESSION['Unothorized']="< div class='error'>Unothorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }



?>
