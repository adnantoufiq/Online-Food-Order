<?php  

        //check whter the user login or not
        
    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message']= "<div class='error text-center'> Please login to acess admin panel.</div>";

        header('location:'.SITEURL.'admin/login.php');
    }

?>