<?php include('partials/menu.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1>Update Order</h1>
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
         $sql="SELECT * FROM tbl_order WHERE id=$id";
         $res=mysqli_query($conn,$sql);
         $count=mysqli_num_rows($res);
         if($count==1)
         {
           $row=mysqli_fetch_assoc($res);
           $food=$row['food'];
           $qty=$row['qty'];
           $order_date=$row['order_date'];
           $status=$row['status'];
         }
         else
         {
          header("location:".SITEURL.'admin/manage-order.php');
         }
       }
       else
       {
        header("location:".SITEURL.'admin/manage-order.php');
       }
    ?>
   
    <form action="" method="post">
      <table class="tbl_40">
        <tr>
          <td>Food Name</td>
          <td><b><?php echo $food; ?></b></td>
        </tr>
        <tr>
          <td>Quantity</td>
          <td><?php echo $qty; ?></td>
        </tr>
        <tr>
          <td>Order Date</td>
          <td><?php echo $order_date; ?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td>
            <select name="status">
              <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
              <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
              <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
              <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update Order" class="btn-primary">
          </td>
        </tr>
      </table>
    </form>

    <?php
      if(isset($_POST['submit']))
      {
        $id=$_POST['id'];
        $status=$_POST['status'];
        $sql2="UPDATE tbl_order SET status='$status' WHERE id=$id";
        $res2=mysqli_query($conn,$sql2);
        if($res2==true)
        {
          $_SESSION['update']="<div class='success'>Status Updated Successfully</div>";
          header("location:".SITEURL."admin/manage-order.php");
        }
        else
        {
          $_SESSION['update']="<div class='error'>Failed to update status</div>";
          header("location:".SITEURL."admin/update-order.php");
        }
      }
    ?>

  </div>
</div>
<?php include('partials/footer.php'); ?>