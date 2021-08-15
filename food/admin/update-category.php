<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update category</h1>

        <br><br>

        <?php 
        
                if(isset($_GET['id']))
                {
                    //echo 'get id';
                    $id=$_GET['id'];
                    $sql="SELECT *FROM tbl_category Where id=$id";

                    $res=mysqli_query($conn,$sql);
                    $count=mysqli_num_rows($res);
                }
                else
                {
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                if($count==1)
                {
                    //get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
        
        
        
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table clss="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                    <input type="text" name="title" value="<?php echo $title;?> ">
                    </td>
                </tr>
                <tr>
                        <td>Current image:</td>
                            <td>
                                <?php
                                    if($current_image!=" ")
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width ="150px">
                                        <?php
                                    }
                                    else
                                    {

                                    }
                                
                                ?>
                            </td>
                </tr>
                <tr>

                    <td>New Image:</td>
                    <td>
                        <input type="file" name= "image">
                    </td>
                </tr>

                
                <tr>
                        <td>Feature:</td>
                        <td>
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                           
                        </td>
                </tr>

                <tr>

                        <td>Active:</td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?>  type="radio" name="active" value="Yes"> Yes
                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                        </td>
                </tr>

                <tr>
                        <td>
                            <input type="hidden" name="current_image" value ="<?php echo $current_image;?>">
                            <input type="hidden" name="id" value ="<?php echo $id;?>">
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                        </td>
                </tr>












            </table>
        </form>
        
        <?php

            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1. get all the values from our form

                $title = $_POST['title'];
                $id = $_POST['id'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.updating new image if selected
                //check the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];

                    //check the image is available or not
                    if($image_name != "")
                    {
                        //image available
                        //upload the new image

                        //auto rename our image
                        //get the extension of our image (jpg,png,gif,etc)

                        $ext = end(explode('.', $image_name));

                        //rename the image
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check the image is uploaded or not
                        //if its not then we will stop the process

                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }





                        //remove the current image if available
                        if($current_image !="")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);
                            //check it is remove or not

                            if($remove==false)
                            {
                                //failed to remove
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image. </div>";

                                header('location:'.SITEURL.'admin/manage-category.php');
                                //stop the process
                                die();
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }

                //3. update the database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                    
                    
                ";

                //execute the query

                $res2 = mysqli_query($conn, $sql2);


                //4. redirect to manage category with message
                //check whether executed or not
                if($res2==true)
                {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }



        ?>








    </div>
</div>


<?php include('partials/footer.php'); ?>
