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

    $status = "";
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Shipping</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <!-- <link rel="stylesheet" href="css/register-login-new.css"> -->
        <link rel="stylesheet" href="css/dropdown.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/shipping.css">
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
        <div class="wrapper">
            <div class="banner"><h1>Shipping</h1></div>
            <?php
                if(isset($_SESSION['emptyaddresserror'])){
                    echo "<div class='normal-text oh-no'>
                            <div>
                                <h3>Oh no!</h3>
                                <p>It looks like we don't have an address in our <br>records for your account.*</p>
                            </div>
                        </div>";
                }
            ?>
            <!-- <div class="normal-text">
                <h3>Oh no!</h3>
                <p>It looks like we don't have an address in our <br>records for your account.*</p>
               
            </div> -->
            <div class="container">
            <div class="cartorder">
                    <?php
                        if(isset($_SESSION['user_shopping_cart'])) {
                            $_SESSION['total_price'] = 0;
                    ?>
                    <table class="table">
                        <tbody>
                            <tr><td colspan="4">&nbsp;</td></tr>

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
                                        <input name="quantity" class="quantity" onchange="this.form.submit()" value="<?=$product['quantity']?>" readonly>
                                    </form>
                                </td>
                                <td class="righttext"><?="$".number_format((float)$product['price'] * $product['quantity'], 2, '.', ''); ?></td>
                            </tr>
                            <?php
                                $_SESSION['total_price'] += ($product['price'] * $product['quantity']);
                                }
                            ?>
                            <tr>
                                <td colspan="4" style="text-align:right;"><strong>TOTAL: <?="$".number_format((float)$_SESSION['total_price'], 2, '.', ''); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="returnshopping">
                        <a href="cart.php">Return to Cart</a>
                    </div>
                    <?php
                        }

                        else {
                            echo "<h3>Your Cart is Empty</h3>";
                        }
                    ?>
                </div>
                <form action="controller.php" class="form-container adressform" name="newcustomer" method="POST">
                    <div class="formwrapper">
                        <div class="form">
                            <input type="text" id="streetadd" class="form__input" autocomplete="new-password" placeholder=" " name="streetadd" value='<?php 
                        if(isset($_POST["streetadd"])){
                            echo htmlentities($_POST["streetadd"]);
                        } 
                        else if(isset($_SESSION["currentaddress"])) {
                            echo ($_SESSION['currentaddress']);
                        }?>'>
                            
                            <label for="streetadd" class="form__label">Street Address</label>
                        </div>
                    </div>
                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                        <?php 
                        if(isset($_SESSION["updateaddress-error"])) {
                            if(in_array("address-error", $_SESSION["updateaddresserrors"])) {
                                echo "You must enter your Address";
                            } 
                        }
                        ?>
                    </div>

                    <div class="formwrapper">
                        <div class="form">
                            <input type="text" id="suburb" class="form__input" autocomplete="new-password" placeholder=" " name="suburb" value='<?php 
                            if(isset($_POST["suburb"])){
                                echo htmlentities($_POST["suburb"]);
                            } 
                            else if(isset($_SESSION["currentsuburb"])) {
                                echo ($_SESSION['currentsuburb']);
                            }?>'>
                            <label for="suburb" class="form__label">Suburb</label>
                        </div>
                    </div>
                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                        <?php 
                        if(isset($_SESSION["updateaddress-error"])) {
                            if(in_array("suburb-error", $_SESSION["updateaddresserrors"])) {
                                echo "You must enter your Suburb";
                            } 
                        }
                        ?>
                    </div>

                    <div class="formwrapper">
                        <div class="form">
                            <input type="text" id="city" class="form__input" autocomplete="new-password" placeholder=" " name="city" value='<?php 
                            if(isset($_POST["city"])){
                                echo htmlentities($_POST["city"]);
                            } 
                            else if(isset($_SESSION["currentcity"])) {
                                echo ($_SESSION['currentcity']);
                            }?>'>
                            <label for="city" class="form__label">City</label>
                        </div>
                    </div>
                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                        <?php 
                            if(isset($_SESSION["updateaddress-error"])) {
                                if(in_array("city-error", $_SESSION["updateaddresserrors"])) {
                                    echo "You must enter your City";
                                } 
                            }
                            ?>
                    </div>

                    <div class="formwrapper">
                        <div class="form">
                            <input type="text" id="country" class="form__input" autocomplete="new-password" placeholder=" " name="country" value='<?php 
                            if(isset($_POST["country"])){
                                echo htmlentities($_POST["country"]);
                            } 
                            else if(isset($_SESSION["currentcountry"])) {
                                echo ($_SESSION['currentcountry']);
                            }?>'>
                            <label for="country" class="form__label">Country</label>
                        </div>
                    </div>
                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                        <?php 
                        if(isset($_SESSION["updateaddress-error"])) {
                            if(in_array("country-error", $_SESSION["updateaddresserrors"])) {
                                echo "You must enter your Country";
                            } 
                        }
                        ?>
                    </div>
                    
                    <input type="hidden" name="ordernumber" value="<?php echo $currentorderid+1 ?>">
                    <input type="hidden" name="action" value="updateaddress">
                    <button type="submit" class="updateaddress">Submit Order</button>
                    <div class="normal-text">
                        <p>* Entering new or changing details here will<br>automatically update your account address.</p>
                    </div>
                </form>
                
                <!-- <div class="returnshopping">
                    <a href="index.php">Return to Shopping</a>
                </div> -->
            </div>
        </div>
    </body>
</html>