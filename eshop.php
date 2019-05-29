<?php
session_start();
$product_ids = array();

if (filter_input(INPUT_POST, 'add_to_cart')){
if (isset($_SESSION['shopping_cart'])){
  $count = count($_SESSION['shopping_cart']);

  $product_ids = array_column($_SESSION['shopping_cart'], 'id');

  if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
    $_SESSION['shopping_cart'][$count] = array(
      'id' => filter_input(INPUT_GET, 'id'),
      'image' => filter_input(INPUT_POST, 'image'),
      'name' => filter_input(INPUT_POST, 'name'),
      'price' => filter_input(INPUT_POST, 'price'),
      'quantity' => filter_input(INPUT_POST, 'quantity')
    );
  }
  else {
    for ($i=0; $i < count($product_ids); $i++){
      if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
        $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
      }
    }
  }
  ?>
  <script type="text/javascript">
    var name = "<?php echo $_SESSION['shopping_cart'][$count]['name'] ?>";
    var quantity = "<?php echo $_SESSION['shopping_cart'][$count]['quantity'] ?>";
    alert("You have order "+ quantity +" of "+ name +".");
  </script>
  <?php
}
else {
  $_SESSION['shopping_cart'][0] = array(
    'id' => filter_input(INPUT_GET, 'id'),
    'image' => filter_input(INPUT_POST, 'image'),
    'name' => filter_input(INPUT_POST, 'name'),
    'price' => filter_input(INPUT_POST, 'price'),
    'quantity' => filter_input(INPUT_POST, 'quantity')
  );
}
}
$total = 0;
$totalQ = 0;
foreach ($_SESSION['shopping_cart'] as $key => $product){
  $total = $total + ($product['quantity'] * $product['price']);
  $totalQ = $totalQ + $product['quantity'];
}
?>
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
    <li>Total: € <?php print_r($total) ?></li>
    <li>Items: <?php print_r($totalQ) ?></li>
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
<div style="clear:both;"></div>
<?php
if (isset($_SESSION['shopping_cart'])):
if (count($_SESSION['shopping_cart']) > 0):
?>
<br />
<div class="table-responsive">
  <table class="table">
    <tr>
      <th colspan="6"><h3>Order Details</h3></th>
    </tr>
    <tr>
      <th width="10%">Image</th>
      <th width="30%">Product Name</th>
      <th width="10%">Quantity</th>
      <th width="20%">Price</th>
      <th width="15%">Total</th>
      <th width="5%">Action</th>
    </tr>
    <?php
    foreach ($_SESSION['shopping_cart'] as $key => $product):
    ?>
      <tr>
        <td><img src="<?php echo $product['image'] ?>" style="width: 55px; height: 55px;"/></td>
        <td><?php echo $product['name']; ?></td>
        <td><?php echo $product['quantity']; ?></td>
        <td>€ <?php echo $product['price']; ?></td>
        <td>€ <?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
        <td>
          <a href="eshop.php?action=delete&id=<?php echo $product['id']; ?>">
            <div class="btn-danger">Remove</div>
          </a>
        </td>
      </tr>
    <?php
    endforeach;
    ?>
    <tr>
      <td colspan="4" align="right">Total</td>
      <td align="right">€ <?php echo number_format($total, 2); ?></td>
      <td></td>
    </tr>
  </table>
</div>
<?php
endif;
endif;
?>
</div>
</body>
</html>
