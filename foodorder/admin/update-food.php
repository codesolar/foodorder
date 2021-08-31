<?php include('partials/menu.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1>Update Food</h1>
    <br><br>
    <?php
       if(isset($_SESSION['update']))
       {
         echo $_SESSION['update'];
         unset($_SESSION['update']);
       }
    ?>
    <br><br>
    <?php
    if(isset($_GET['id']))
    {
       $id=$_GET['id'];
       $sql2="SELECT * FROM tbl_food WHERE id=$id";
       $res2=mysqli_query($conn,$sql2);

       if($res2==TRUE)
       {
        $count=mysqli_num_rows($res2);
        if($count==1)
        {
          $rows2=mysqli_fetch_assoc($res2);
          $title=$rows2['title'];
          $description=$rows2['description'];
          $price=$rows2['price'];
          $current_image=$rows2['image_name'];
          $current_category=$rows2['category_id'];
          $featured=$rows2['featured'];
          $active=$rows2['active'];
        }
        else
        {
          header("location:".SITEURL."admin/manage-food.php");
        }
       }
    }
    else
    {
      header("location:".SITEURL."admin/manage-food.php");
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl_40">
        <tr>
          <td>Title</td>
          <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
        </tr>
        <tr>
          <td>Description</td>
          <td>
            <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
          </td>
        </tr>
        <tr>
          <td>Price</td>
          <td>
            <input type="number" name="price" value="<?php echo $price; ?>">
          </td>
        </tr>
        <tr>
          <td>Current Image</td>
          <td>
            <?php
               if($current_image!="")
               {
                 ?>
                 <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                 <?php
               }
               else
               {
                 echo "<div class='error'>Image Not Added</div>";
               }
            ?>
          </td>
        </tr>
        <tr>
          <td>New Image</td>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <td>Category</td>
          <td>
            <select name="category">
              <?php
                 $sql="SELECT * from tbl_category WHERE active='Yes'";
                 $res=mysqli_query($conn,$sql);
                 $count=mysqli_num_rows($res);
                 if($count>0)
                 {
                   while($rows=mysqli_fetch_assoc($res))
                   {
                     $category_id=$rows['id'];
                     $category_title=$rows['title'];
                     ?>
                     <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                     <?php
                   }
                 }
                 else
                 {
                   ?>
                   <option value="0">No category Found</option>
                   <?php
                 }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Featured</td>
          <td>
            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
          </td>
        </tr>
        <tr>
          <td>Active</td>
          <td>
            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="submit" name="submit" value="Update Food" class="btn-primary">
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php
   if(isset($_POST['submit']))
   {

     $id=$_POST['id'];
     $title=$_POST['title'];
     $description=$_POST['description'];
     $price=$_POST['price'];
     $category=$_POST['category'];
     $current_image=$_POST['current_image'];
     $featured=$_POST['featured'];
     $active=$_POST['active'];

     if(isset($_FILES['image']['name']))
     {
       $image_name=$_FILES['image']['name'];
       if($image_name!="")
       {
        $ext=end(explode('.',$image_name));
        $image_name="Food_Name_".rand(0000,9999).'.'.$ext;
    
        $src_path=$_FILES['image']['tmp_name'];
        $dest_path="../images/food/".$image_name;
        $upload=move_uploaded_file($src_path,$dest_path);
        if($upload==false)
        {
          $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
          header("location:".SITEURL."admin/manage-food.php");
          die();
        }
        if($current_image!="")
        {
          $remove_path="../images/food/".$current_image;
          $remove=unlink($remove_path);
          if($remove==false)
          {
          $_SESSION['failed-remove']="<div class='error'>Failed to remove current image</div>";
          header("location:".SITEURL."admin/manage-food.php");
          die();
          }
        }
        
       }
       else
       {
        $image_name=$current_image;
       }
     }
     else
     {
       $image_name=$current_image;
     }
   
     $sql3="UPDATE tbl_food SET
       title='$title',
       description='$description',
       price=$price,
       image_name='$image_name',
       category_id=$category,
       featured='$featured',
       active='$active' 
       WHERE id=$id
      ";
  
  $res3=mysqli_query($conn,$sql3);
  if($res3==TRUE)
  {
    $_SESSION['update']="<div class='success'>Food Updated Successfully</div>";
    header("location:".SITEURL."admin/manage-food.php");
  }
  else
  {
    $_SESSION['update']="<div class='error'>Failed to update food</div>";
    header("location:".SITEURL."admin/update-food.php");
  }
}
  
?>

<?php include('partials/footer.php'); ?>