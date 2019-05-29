<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>e-Shop || BFMV</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="image/bfmv_icon.jpg" />
</head>
<body>
<div class="navi">
  <ul>
    <li>Total: €</li>
    <li>Items:</li>
    <li class="left"><a class="active" href="index.html">Home</a></li>
    <li class="left"><a class="active" href="eshop.php">e-Shop</a></li>
  </ul>
</div>
<?php
$connect = mysqli_connect('localhost', 'username', 'password', 'table');
$query = 'SELECT * FROM products ORDER by id ASC';
$result = mysqli_query($connect, $query);
if($result):
  if(mysqli_num_rows($result)>0):
    while ($product = mysqli_fetch_assoc($result)):
      ?>
      <div class="col-sm-4 col-md-3">
        <form method="post" action="eshop.php?action=add&id=<?php echo $product['id']; ?>">
          <div class="products">
            <img src="<?php echo $product['image'] ?>" class="img-responsive" />
            <h4 class="text-danger"><?php echo $product['name'] ?></h4>
            <h4>€ <?php echo $product['price'] ?></h4>
            <input type="text" name="quantity" class="form-control" value="1" />
            <input type="hidden" name="image" value="<?php echo $product['image'] ?>" />
            <input type="hidden" name="name" value="<?php echo $product['name'] ?>" />
            <input type="hidden" name="price" value="<?php echo $product['price'] ?>" />
            <input type="submit" name="add_to_cart" class="btn" value="Add to Cart" />
          </div>
        </form>
      </div>
      <?php
    endwhile;
  endif;
endif;
?>  
</body>
</html>
