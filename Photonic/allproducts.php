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

    require'private/shopping_function.php';

    $status = "";
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Products</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/dropdown.css">
        <link rel="stylesheet" href="css/popup.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
            // $(window).on('load', function(){
                $(".trigger_popup_fricc").click(function(){
                    $('.hover_bkgr_fricc').show();
                });
                $('.hover_bkgr_fricc').click(function(){
                    $('.hover_bkgr_fricc').hide();
                });
                $('.popupCloseButton').click(function(){
                    $('.hover_bkgr_fricc').hide();
                });

                $(".trigger_status").click(function(){
                    $('.hover_status').show();
                });
                $('.hover_status').click(function(){
                    $('.hover_status').hide();
                });
                $('.statusPopupCloseButton').click(function(){
                    $('.hover_status').hide();
                });
            });
        </script>
        <?php if(isset($_SESSION['loginCartError'])){ ?>
        <script>
            $(document).ready(function(){
                $(".trigger_popup_fricc").click();
            });
        </script>
        <?php }?>
        <?php if(isset($_SESSION["status"])){ ?>
        <script>
            $(document).ready(function(){
                $(".trigger_status").click();
            });
        </script>
        <?php }?>
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
                        <?php 
                            if($obj->userHasRole(1) == true){
                                echo "<li><a href='displaycatalogue.php'>Admin Page</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wrapper" id="wrapper">
            <!-- <div class="banner">
                <img src="images/banner.png" alt="Promotional Banner">
            </div> -->
            <h1>All Products</h1>  
            <div class="product-container">
            <?php
                foreach ($_SESSION['categoryresults'] as $row) {
                    echo"
                    <div class='product_wrapper'>
                        <form class='card' method='POST'>
                            <input type='hidden' name='id' value=" . $row['id'] .">
                            <div class='name'>" . $row['name'] . "</div>
                            <div class='image'><img src='" . $row['image'] ."' alt='" .$row['name'] ."'></div>
                            <div class='price'> $" .$row['price'] ."</div>
                            <button type='submit' class='buy'>Buy Now</button>
                        </form>
                    </div>";
                }
            ?>
            </div>
                        
        </div>
        <a class="trigger_popup_fricc"></a>
        <div class="hover_bkgr_fricc">
            <span class="helper"></span>
            <div>
                <div class="popupCloseButton">&times;</div>
                <p><br><?php if(isset($_SESSION['loginCartError'])){ echo $_SESSION['loginCartError']; unset($_SESSION['loginCartError']);} ?></p>
            </div>
        </div>
        <a class="trigger_status"></a>
        <div class="hover_status">
            <span class="helper"></span>
            <div>
                <div class="statusPopupCloseButton hidden">&times;</div>
                <p><br><?php if(isset($_SESSION["status"])){ echo $_SESSION["status"]; unset($_SESSION["status"]);} ?></p>
            </div>
        </div>
        <script src="js/swiper.js"></script>
        <script src="js/stickyheader.js"></script>
        <!-- <script src="js/log-reg.js"></script> -->
        <footer>
            <div class="footer-wrapper">
                <p>Bradley Chung</p>
                <a href="privacy.php">Privacy Statement</a>
            </div>
        </footer>
    </body>
</html>