<!-- Video 7 -->
<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>

                </tr>
                
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="description of the food."></textarea>
                    </td>

                </tr>
                
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                
                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                                //create php code to display categories form database
                                //1. create sql to get all active categories from database
                                $sql = "SELECT * From tbl_category where active='Yes'";

                                //executing query
                                $res = mysqli_query($conn, $sql);

                                //count rowa to check whether we have categories or not
                                $count = mysqli_num_rows($res);
                                //if count is greeater than zero, we have categories else we do not have
                                if($count>0)
                                {
                                    //we have categories
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php

                                }
                                //2. display on dropdown
                            ?>
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
            //check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                //Add the food in database
                //echo "clicked"
                
                //1. get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";//setting the default value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";//setting the default value
                }



                //2. upload the image if selected
                //check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    //check whether the image is selected or not and upload image only if seleceted
                    if($image_name!="")
                    {
                        //image is selected
                        //A. rename the image
                        //get the extension of sleceted image(jpg, png, gif, etc.) "image.jpg" image jpg
                        $ext = end(explode('.',$image_name));

                        // create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;//new image may be "Food-Name-657.jpg"
                        
                        //B. upload the image
                        //Get the src path and destination path
                        // source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //destination path for the image to be uploaded
                        $dst = "../images/food/".$image_name;
                        //Finally upload the image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image is uploaded or not
                        if($upload==false)
                        {
                            //failed to upload the image
                            //redirect to add food page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = "";//setting default value as blank
                }
                //3. insert into database
                // create  a sql query to save or add food
                // quotes '' is only needed for string but not for numerical values
                $sql2 = "INSERT into tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";
                
                //Execute the query
                $res3=mysqli_query($conn,$sql2);

                //check whther data inserted or not
                //4. Redirect with message to manage food page
                if($res3 == true)
                {
                    //Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        
        ?>
    </div>
</div>

<?php include ('partials/footer.php'); ?>