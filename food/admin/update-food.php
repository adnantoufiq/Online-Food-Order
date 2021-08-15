<?php include('partials/menu.php');?>
<?php

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $sql3="SELECT * FROM tbl_food where id=$id";

    $res3=mysqli_query($conn,$sql3);


    $row4=mysqli_fetch_assoc($res3);

    $title=$row4['title'];
    $description=$row4['description'];
    $price=$row4['price'];
    $current_image=$row4['image_name'];
    $current_category=$row4['category_id'];
    $featured=$row4['featured'];
    $active=$row4['active'];

}
else
{
    header('location:'.SITEURL.'admin/manage-food.php');
}






?>


<div class="main-content">

    <div class="wrapper">
            <h1>Update Food</h1>
    
            <br></br>
            <form action="" method="post" enctype="multipart/form-data">
            <table class ="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text " name="title" value="<?php echo $title;?>">
                    </td>
                </tr> 

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo $description ;?></textarea>
                    </td>

                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image=="")
                            {
                                echo "<div class= 'error'>Image not Avaiable.</div>";
                            }
                            else
                            {
                                ?>
                                    <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>"width="100px">
                                <?php
                            }
                        
                        
                        
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            
                            $sql = "SELECT * From tbl_category where active='Yes'";

                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);
                            if($count>0)
                            {
                                //we have categories
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    //get the details of categories
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    
                                    //echo "<option value='$category_id'> $category_title</option>";
                                    ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title;?></option>
                                    <?php
                                    
                                }
                            }
                            else
                            {
                                //we do not have category
                                ?>
                                <option value="0">Category Not Available</option>;
                                <?php

                            }

                            
                            
                            
                            
                            
                            ?>
                          
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){ echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){ echo "checked";} ?>  type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden"  name="id" value="<?php echo $id ;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="Update food" class="btn-secondary">
                    </td>
                </tr>

                






            </table>


            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    //echo'clicked';

                    //Get all the details from the form

                    $id=$_POST['id'];
                    $title=$_POST['title'];
                    $description=$_POST['description'];
                    $price=$_POST['price'];
                    $current_image=$_POST['current_image'];
                    $category=$_POST['category'];
                    $featured=$_POST['featured'];
                    $active=$_POST['active'];

                    //Upload the image if selected

                    //Checked wheter the upload button click or not

                    if(isset($_FILES['image']['name']))
                    {
                        $image_name=$_FILES['image']['name'];//neew image name

                        //check whether the file is available or not
                        if($image_name!="")
                        {
                            //iamge is avaiable
                            //rename the iamge
                            $ext=end(explode('.',$image_name));
                            $image_name="Food-Name-".rand(0000,9999).'.'.$ext;//this will be rename image

                            //get the source path and dest path
                            $src_path= $_FILES['image']['tmp_name'];
                            $dest_path="../images/food/".$image_name;

                            //upload the image
                            $upload=move_uploaded_file($src_path,$dest_path);

                            //check wheter the image is uploaded or not

                            if($upload==false)
                            {
                                //failed to upload
                                $_SESSION['upload']="<div class='error'>Failed To Upload Image.</div>";

                                //redirect to mange food

                                header('location:'.SITEURL.'admin/manage-food.php');

                                die();
                            }

                            //remove current image if available
                            if($current_image!="")
                            {
                                //remove the image
                                $remove_path="../images/food/".$current_image;

                                $remove=unlink($remove_path);

                                //check whter the image is remove or not
                                if($remove==false)
                                {
                                    $_SESSION['remove-failed']="<div class='error'>Failed To remove iamge.</div>";

                                    header('location:'.SITEURL.'admin/manage-food.php');

                                    die();
                                }
                            }
                        }
                        else
                        {
                            $image_name=$current_image;//default image when image  is not selected
                        }
                    }
                    else
                    {
                        $image_name=$current_image;//deafult image when button is not
                    }

                    //update the food in database

                    $sql4="UPDATE tbl_food set 
                            title='$title',
                            description='$description',
                            price=$price,
                            image_name='$image_name',
                            category_id='$category',
                            featured='$featured',
                            active='$active'
                            Where id= $id
                    
                    
                    ";
                    //exicute the query
                    $res4=mysqli_query($conn,$sql4);

                    if($res4==true)
                    {
                        //query exicuted and food update
                        $_SESSION['update']="<div class='success'> Food Updated Successfully.</div>";

                        header('location:'.SITEURL.'admin/manage-food.php');

                    }
                    else
                    {
                        //failed to update food

                        $_SESSION['update']="<div class='error'> Failed To Update Food.</div>";

                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
            
            
            
            
            
            ?>
           
            
            
            
         



      

    </div>
</div>


<?php include('partials/footer.php');?>