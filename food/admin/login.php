<?php include('../config/constants.php');?>
<html>

    <head>
        <title> Login- Food Order Syestem</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        
        <div class='login'>
            <h1  class= "text-center" >Login </h1>
            <br>
            </br>
            <?php
            
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
                
                
            
            ?>
            <br><br>

            <!-- form starts here -->

            <form action="" method="post" class="text-center">

            Username:<br>

            <input type ="text" name="username" placeholder="Enter UserName"><br><br>
            Password:<br>

            <input type ="password" name="password" placeholder="Enter Password"><br><br>
            
            

            <input type="submit" name="submit" value="Login" class="btn-primary" >
            </form><br>
            <!-- form ends here -->
            

            <p  class= "text-center" > Created By-- <a href="#"></a> Ariful Islam Toufiq </a></p>
        </div>

    </body>
</html>

<?php

    if(isset($_POST['submit']))
    {
         $username=mysqli_real_escape_string($conn, $_POST['username']);
         $raw_password=md5($_POST['password']);
         $password=mysqli_real_escape_string($conn, $raw_password);
        
        $sql="SELECT * FROM tbl_admin WHERE User_Name= '$username' AND Password	='$password' ";



        $res=mysqli_query($conn,$sql);


        $count=mysqli_num_rows($res);

        if($count==1)
        {
            $_SESSION['login']="<div class= 'right text-center'>login Succesfull.</div>";
            $_SESSION['user']=$username;
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            $_SESSION['login']="<div class= 'error text-center'>login failed.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }


        
    }

?>