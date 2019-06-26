<?php
session_start();
$product_ids = array();
session_destroy();

if (filter_input(INPUT_POST, 'add_to_cart')){
    if (isset($_SESSION['shopping_cart'])){
        $count = count($_SESSION['shopping_cart']);
        $product_ids = array_column($_SESSION['shopping_cart'],id);

        if (!in_array(filter_input(INPUT_GET, id), $product_ids)){
            $_SESSION['shopping_cart'][$count] = array(
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }else{
            for ($i=0; $i<count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, id)){
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, quantity);
                }
            }
        }
    }else{
        $_SESSION['shopping_cart'][0] = array(
            'id' => filter_input(INPUT_GET, 'id'),
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
    );
    }
}
//pre_r($_SESSION);

function pre_r($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
?>
<html>
    <head>
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="cart.css">
    </head>

    <body>
    <div class="container">
        <div class="row">
        <?php
        /**
         * Created by PhpStorm.
         * User: Maheshi
         * Date: 4/21/2019
         * Time: 1:43 AM
         */
        $connect = mysqli_connect("localhost", "root", "", "cart");
        $query = "SELECT * FROM products ORDER by id ASC ";

        $result = mysqli_query($connect, $query);

        if ($result):
            if (mysqli_num_rows($result)>0):
                while ($product = mysqli_fetch_assoc($result)):
                    ?>
                    <div class="col-md-3">
                        <form method="post" action="index.php?action=add&id=<?php $product[id]; ?>">
                            <div class="products">
                                <img src="<?php echo $product['image']; ?>" class="img-responsive">
                                <h4 class="text-info"><?php echo $product['name'];?></h4>
                                <h4>$ <?php echo $product['price'];?></h4>
                                <input type="text" name="quantity" class="form-control" value="1">
                                <input type="hidden" name="name" value="<?php echo $product['name'];?>">
                                <input type="hidden" name="price" value="<?php echo $product['price'];?>">
                                <input type="submit" name="add_to_cart" class="btn btn-info" value="Add to cart"
                                style="margin-top: 5px">
                            </div>
                        </form>
                    </div>
                    <?php
                endwhile;
            endif;
        endif;
        ?>
            <div style="clear: both"></div>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th colspan="5"><h3>Order Details</h3></th>
                    </tr>
                    <tr>
                        <th width="40%">Product Name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    <?php
                    if (!empty($_SESSION['shopping_cart']));

                        $total = 0;

                        foreach ($_SESSION['shopping_cart'] as $key => $product);
                    ?>
                    <tr>
                        <td
                    </tr>
                </table>
            </div>
        </div>
    </div>

    </body>
</html>
