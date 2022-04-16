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

    // $results = $obj->getallproductdata("products");
    // $categories = $obj->getallcategoriesdata("categories");
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Account</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/register-login-old.css">
        <link rel="stylesheet" href="css/dropdown.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="nav">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo-white.svg" alt="Photonic Photography Logo">
                </a>
            </div>
            <div class="links">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="displaycatalogue.php">Products</a></li>
                    <li><a href="displayusers.php">Users</a></li>
                    <li><a href="#">Orders</a></li>
                </ul>
            </div>
            <div class="right-header">
                <div class="header-icon">
                    <ul>
                        <li class="signin-reg">
                            <?php
                                if(isset($_SESSION['loggedIn']) == FALSE) {
                                    echo "<i class='fas fa-user'></i>";
                                    echo "<a href='account.php' class='userIcon' id='signinbtn'> Account </a>";
                                }
                            ?>
                        </li>
                        <li>
                            <div class="dropdown">
                                <?php
                                    if(isset($_SESSION['loggedIn']) == TRUE) {
                                        echo "<a href='account.php' class='userIcon dropbtn'><i class='fas fa-user'></i> " . ucfirst($_SESSION['username']) . " </a>";
                                    }
                                ?>
                                <div class="dropdown-content">
                                    <a href="#">Test content</a>
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
                        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    </ul>
                </div> 
            </div>
        </div>

        <div class="wrapper">
            <div class="banner"><h1>Account</h1></div>
            <div class="account-page">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-container registerform">
                                <div class="form-btn">
                                    <span>Sign Up</span>
                                    <hr id="indicator">
                                </div>
                                <form id="regForm" action="register.php" method="POST">
                                    <input type="text" name="firstname" placeholder="First Name" class="<?php if(isset($_SESSION['registration-error'])) {if(in_array('firstname-error', $_SESSION['registrationerrors']))
                                        echo 'error';}?>" value="<?php if(isset($_POST['firstname'])) {echo htmlentities($_POST["firstname"]);}?>">
                                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                                        <?php 
                                            if(isset($_SESSION["registration-error"])) {
                                                if(in_array("firstname-error", $_SESSION["registrationerrors"])) {
                                                echo "You must enter your first name";
                                                } 
                                            }
                                        ?>
                                    </div>

                                    <input type="text" placeholder="Your Last Name" name="lastname" class="<?php if(isset($_SESSION['registration-error'])) {if(in_array('lastname-error', $_SESSION['registrationerrors']))
                                        echo 'error';}?>" value="<?php if(isset($_POST['lastname'])) {echo htmlentities($_POST['lastname']);}?>">
                                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                                        <?php 
                                            if(isset($_SESSION["registration-error"])) {
                                                if(in_array("lastname-error", $_SESSION["registrationerrors"])) { 
                                                    echo "You must enter your last name";
                                                } 
                                            }
                                        ?>
                                    </div>

                                    <input type="text" type="email" placeholder="Your Email" name="email" class="<?php if(isset($_SESSION['registration-error'])) {if(in_array('email-error', $_SESSION['registrationerrors']))
                                        echo 'error';}?>" value="<?php if(isset($_POST['email'])) {echo htmlentities($_POST["email"]);}?>">
                                    <div class="errormsg <?php if(isset($_SESSION['registration-error'])){ echo 'error';} ?>">
                                        <?php
                                            if(isset($_SESSION["registration-error"])) {
                                                if(in_array("email-error", $_SESSION["registrationerrors"])){
                                                    echo "You must enter your email address";
                                                }
                                                else if($_SESSION["duplicateEmail"] == true) {
                                                    // echo $_SESSION["duplicateEmail"];
                                                    echo "This e-mail address has already been used";
                                                }
                                            }
                                        ?>
                                    </div>
                                    
                                    <input type="password" placeholder="Your Password" name="psw" class="<?php if(isset($_SESSION["pswregistration-error"])) {echo "error";}?>">
                                    <div class="errormsg <?php if(isset($_SESSION["pswregistration-error"])){ echo 'error';} ?>">
                                        <?php
                                            if(isset($_SESSION["psw-error"])) {
                                                echo "You must enter a passowrd";  
                                            }
                                        ?>
                                    </div>

                                    <input type="password" placeholder="Confirm Password" name="confirmpsw" class="<?php if(isset($_SESSION["pswregistration-error"])){ echo "error";} ?>">
                                    <div class="errormsg <?php if(isset($_SESSION["pswregistration-error"])){ echo 'error';} ?>">
                                        <?php
                                            if(isset($_SESSION["passwordmatch-error"])) {
                                                echo "Passwords do not match";
                                            }
                                        ?>
                                    </div>

                                    <button type="submit" name="register" class="btn">Sign Up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/log-reg.js"></script>
    </body>
</html>