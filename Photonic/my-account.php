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

    if(isset($_SESSION['loggedIn'])) {
        if(isset($_POST['id']) && $_POST['id'] != ""){
            $id = $_POST['id'];
        }
    }
    $userid = $_SESSION['userid'];
    // $results = $obj->getallproductdata("products");
    // $categories = $obj->getallcategoriesdata("categories");

    $results = $obj->getcurrentuser($userid);

    // print_r($results);
    // exit();
    ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | My Account</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/register-login-new.css">
        <link rel="stylesheet" href="css/dropdown.css">   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="banner">
                <h1>Account</h1>
            </div>
            <div class="account-page">
                <div class="account-status">
                    <?php
                        if(isset($_SESSION['accountstatus'])) {
                            echo 'Your details have been updated';
                        }
                    ?>
                </div>
                <div class="container">
                    <form action="controller.php" class="form" id="form" method="POST" enctype="multipart/form-data">
                        <label for="userid">Current User ID: <span class="sml-text">(Read Only)</span></label>
                        <input type="text" class="userid" name="userid" id="userid" value="<?php echo $results [0] ['userid']; ?>" readonly>

                        <label for="firstname">First Name:</label>
                        <input type="text" class="firstname" name="firstname" id="firstname" value="<?php echo $results [0] ['firstname']; ?>" required>
                        
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="lastname" name="lastname" id="lastname" value="<?php echo $results [0] ['lastname']; ?>" required>

                        <label for="email">Email:</label>
                        <input type="text" class="email" name="email" id="email" value="<?php echo $results [0] ['email']; ?>" required>
                        
                        <label for="streetadd">Street Address:</label>
                        <input type="text" class="streetadd" name="streetadd" id="streetadd" value="<?php echo $results [0] ['streetadd']; ?>" >

                        <label for="city">City:</label>
                        <input type="text" class="city" name="city" id="city" value="<?php echo $results [0] ['city']; ?>">
                        
                        <label for="suburb">Suburb:</label>
                        <input type="text" class="suburb" name="suburb" id="suburb" value="<?php echo $results [0] ['suburb']; ?>">

                        <label for="suburb">Country:</label>
                        <input type="text" class="country" name="country" id="country" value="<?php echo $results [0] ['country']; ?>">
                        
                        <label for="newpsw">New Password:</label>
                        <input type="password" id="newpsw" placeholder="New Password" name="updatepsw">
                        
                        
                        <label for="newconfirmpsw">Confirm New Password:</label>
                        <input type="password" id="newconfirmpsw" placeholder="Confirm New Password" name="updateconfirmpsw" class="<?php if(isset($_SESSION["updatepswadminn-error"])){ echo "error";} ?>">
                        <div class="errormsg <?php if(isset($_SESSION["updatepswradmin-error"])){ echo 'error';} ?>">
                            <?php
                                if(isset($_SESSION["updatepasswordmatch-error"])) {
                                    echo "Passwords do not match";
                                }
                            ?>
                        </div>
                                
                        <button class="display btn" type="submit" name="customeredituserinfo">Update User Information</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            unset($_SESSION['accountstatus']);
        ?>
    </body>
</html>