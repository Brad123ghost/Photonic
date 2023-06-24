<?php
    if(!isset($_SESSION)) {
        session_start();
    }
?>

<!DOCTYPE html>
<?php 
    spl_autoload_register(function ($class) {
        include_once('db.php');
    });

    $obj = new db_photography;

    // $results = $obj->getallproductdata("products");
    // $latestproducts = $obj->getlatestproductdata("products");
    // $categories = $obj->getallcategoriesdata("categories");

    if(!isset($_SESSION['loggedIn'])){
        include 'controller.php';
        exit();
    }
    
    if(!isset($_SESSION['loggedIn'])){
        $_SESSION['loginError'] = "You must login to be able to make purchases.";
        include 'index.php';
        exit();
    }

    $currentorderid = $obj->getcurrentorderid('orders');

    // $_SESSION['cartstatus'] = "";


?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Cart</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/dropdown.css">
        <link rel="stylesheet" href="css/register-login-new.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    </head>
    <body>
    <div class="nav" id="nav">
            <div class="nav-inner-top">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logo-white.svg" alt="Photonic Photography Logo">
                    </a>
                </div>
                <div class="right-header">
                    <div class="header-icon">
                        <ul>
                            <li class="signin-reg">
                                <?php
                                    if(isset($_SESSION['loggedIn']) == FALSE) {
                                        echo "<i class='fas fa-user'></i>";
                                        echo "<a href='account.php' class='userIcon' id='signinbtn'> Login </a>";
                                    }
                                ?>
                            </li>
                            <li class="<?php if(isset($_SESSION['loggedIn']) == FALSE){echo " hidden";} ?>">
                                <div class="dropdown">
                                    <?php
                                        if(isset($_SESSION['loggedIn']) == TRUE) {
                                            echo "<a class='userIcon dropbtn'><i class='fas fa-user'></i> " . ucfirst($_SESSION['username']) . " </a>";
                                        }
                                    ?>
                                    <div class="dropdown-content">
                                        <a href="my-account.php">My Account</a>
                                        <form action="controller.php" class="signoutform" id="signoutform" method="POST">
                                            <div>
                                                <?php
                                                    if(isset($_SESSION['loggedIn']) == TRUE) {
                                                        echo "<input type='hidden' name='action' value='logout'>";
                                                        echo "<input type='hidden' name='goto' value='index.php'>";
                                                        echo "<button type='submit'>Logout</button>";
                                                    }
                                                ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="cart.php">
                                    <i class="fas fa-shopping-cart"></i> 
                                    Cart
                                    <?php
                                        if(!empty($_SESSION['user_shopping_cart'])) {
                                            $cart_count = count(array_keys($_SESSION['user_shopping_cart']));
                                    ?>
                                        <span><?=$cart_count; ?></span>
                                    <?php
                                        }
                                    ?>
                                </a>
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
            <div class="nav-inner-bottom">
                <div class="links">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="allcategories.php">Departments</a></li>
                        <li>
                            <form action='opencontroller.php' id='allproductform' class='viewallproducts' method='POST'>
                                <input type='hidden' name='action' value='viewallproducts'>
                                <button class="button-link" type='submit'>
                                    View all Products
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="outter-wrapper">

            <div class="wrapper">
                <div class="banner"><h1>Cart</h1></div>
                <div class="container">
                    <!-- <header>
    
                        <?php
                            if(isset($_SESSION['userid'])){
                                echo "User ID is ".$_SESSION['userid'];
                            }
                            if(!empty($_SESSION['user_shopping_cart'])) {
                                $cart_count = count(array_keys($_SESSION['user_shopping_cart']));
                        ?>
    
                        <div class="cart-div">
                            <a href="cart.php">
                                <img src="cart-icon.png" alt=""><span><?=$cart_count; ?></span>
                            </a>
                        </div>
                        <?php
                            }
                        ?>
                    </header> -->
                    <p class="ordernumber">Order Number: <?php echo $currentorderid+1 ?></p>
                            
                    <div class="cart">
                        <div class="message_box">
                            <?php
                                if(isset($_SESSION['cartstatus'])) {
                                    echo $_SESSION['cartstatus'];
                                }
                            ?>
                        </div>
                        <?php
                            if(isset($_SESSION['user_shopping_cart'])) {
                                $_SESSION['total_price'] = 0;
                        ?>
                        <table class="table">
                            <tbody>
                                <tr><td colspan="6"></td></tr>
                                <tr>
                                    <td>Product</td>
                                    <td>&nbsp;</td>
                                    <td>QUANTITY</td>
                                    <td class="righttext">UNIT PRICE</td>
                                    <td class="righttext">ITEMS TOTAL</td>
                                    <td>&nbsp;</td>
                                </tr>
    
                                <?php foreach($_SESSION['user_shopping_cart'] as $product) {?>
                                
                                <tr>
                                    <td><img class="product-image" src="<?=$product['image']; ?>" alt=""></td>
                                    <td>
                                        <?=$product['name']; ?>
                                    </td>
    
                                    <td>
                                        <form action="controller.php" method="POST">
                                            <input type="hidden" name="code" value="<?=$product['code']; ?>">
                                            <!-- <input type="hidden" name="action" value="change"> -->
                                            <div class="quantity-container">
                                                <button class="minus" id="minus" name="action" value="minus"><i class="fas fa-minus"></i></button>
                                                <input name="quantity" class="quantity" onchange="this.form.submit()" value="<?=$product['quantity']?>" readonly>
                                                <button class="plus" id="plus" name="action" value="plus"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="righttext"><?="$".number_format((float)$product['price'], 2, '.', ''); ?></td>
                                    <td class="righttext"><?="$".number_format((float)$product['price'] * $product['quantity'], 2, '.', ''); ?></td>
                                    <td>
                                        <form action="controller.php" method="POST">
                                            <input type="hidden" name="code" value="<?=$product['code'];?>">
                                            <input type="hidden" name="id" value="<?=$product['id'];?>">
                                            <input type="hidden" name="action" value="remove">
                                            <button class="remove" type="submit"><i class="far fa-trash-alt fa-lg"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                    $_SESSION['total_price'] += ($product['price'] * $product['quantity']);
                                    }
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align:right;"><strong>TOTAL: <?="$".number_format((float)$_SESSION['total_price'], 2, '.', ''); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                            }
    
                            else {
                                echo "<h3>Your Cart is Empty</h3>";
                            }
                        ?>
                    </div>
                    <div class="submitorder">
                        <form action="controller.php" method="POST">
                            <input type="hidden" name="ordernumber" value="<?php echo $currentorderid+1 ?>">
                            <input type="hidden" name="action" value="shipping">
                            <button type="submit" class="continueshippingbtn">Continue to Shipping</button>
                        </form>
                    </div>
                    <div class="returnshopping">
                        <a href="index.php">Return to Shopping</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $_SESSION['cartstatus'] = "";
        ?>
        <link rel="stylesheet" href="css/cart.css">
    </body>
</html>