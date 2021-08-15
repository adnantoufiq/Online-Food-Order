<?php include('partials/menu.php');?>
<div class=" main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br>
        </br>

        <?php
        
            if (isset($_SESSION['add'])) // checkiing the session is set of not//
            {
                echo($_SESSION['add']); // Display the session message if set//
                unset($_SESSION['add']);// remove session message//

            }   
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="Full_Name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="User_Name" placeholder="Enter User Name"></td>
                </tr>
                <tr>
                    <td>Password </td>
                    <td><input type="password" name="Password" placeholder="Enter Password"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Add Admin" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>

</div>


<?php include('partials/footer.php');?>

<?php
   //process the value from Form  and save it database//
   // check wheter the submit button click or not//

   if(isset($_POST['submit']))
   {
        // button click//
         $full_name = $_POST['Full_Name'];
         $user_name = $_POST['User_Name'];
         $password = md5($_POST['Password']); // md5 is for password encryption//

         // save data into database with the form//

         $sql= "INSERT INTO tbl_admin SET
               Full_Name= '$full_name',
               User_Name='$user_name',
               Password='$password'
                ";

         $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

         // check wheter the data is inserted or not  and display appropiate messege//

         if ($res==TRUE)
         {
             //data inserted//
             //echo "data inserted";
             
             $_SESSION['add']= "<div class='add'>Admin added sucessfully</div>";

             header("location:".SITEURL.'admin/manage-admin.php');

         }
         else
         {
             //data not inserted//
             //echo"not inserted";

             $_SESSION['add']= "<div class='fail'>Faild To Add  Admin</div>";

             header("location:".SITEURL.'admin/add-admin.php');

         }
               
    }

    
   

?>