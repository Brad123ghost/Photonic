<?php
    if(!isset($_SESSION)) {
        session_start();
        $_SESSION["errormsg"] = null;
    }
?>

<!DOCTYPE html>
<?php
    spl_autoload_register(function ($class) {
        include_once('db.php');
    });

    $obj = new db_photography;

    if($obj->userHasRole(1) == false){
        $_SESSION['loginCartError'] = "Only Account Administrators may access the administration pages.";
        header("Location: index.php");
        exit();
    }

?>

<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Edit Users</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/catalogue.css">
        <link rel="stylesheet" href="css/addproduct.css">
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
                            <li>
                                <div class="account">
                                    <div class="nameRole">
                                        <p><?=ucfirst($_SESSION['username']);?> <span class="userRoleIcon"><?=$_SESSION['userrole'];?></span></p>
                                        <form action="controller.php" class="signoutform" id="signoutform" method="POST">                                           
                                            <input type='hidden' name='action' value='logout'>
                                            <input type='hidden' name='goto' value='index.php'>
                                            <button type='submit' class="signOutButton">Sign Out</button> 
                                        </form>    
                                    </div> 
                                </div>
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
            <div class="nav-inner-bottom">
                <div class="links">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="displaycatalogue.php">Products</a></li>
                        <li><a href="displayusers.php">Users</a></li>
                        <li><a href="orders.php">Orders</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="outerwrapper">
            <div class="edituser-container">
                <h2>Edit User</h2>
                <p>Update the user Details and click Submit</p>
                <div class="container">
                    <form action="controller.php" class="form edituserform" id="form" method="POST" enctype="multipart/form-data">
                        <label for="userid">Current User ID: <span class="sml-text">(Read Only)</span></label>
                        <input type="text" class="userid" name="userid" id="userid" value="<?php echo $results [0] ['userid']; ?>" readonly>

                        <div class="groups-inner <?php if(($_SESSION["errormsg"]) == true){echo "error";}?>">
                        <p class=grouplabel>Choose all the appropriate groups <span class="smallText">(You must choose at lease one)</span></p>
                        <?php for($i = 0; $i < count($groups); $i++) { ?>
                            <div class="groupscheckbox">
                                <input type="checkbox" name="groupschosen[]" value="<?=($groups[$i]['groupid']); ?>"
                                <?php
                                    if($groups[$i]['selected']) {
                                        echo ' checked';
                                    }
                                ?>>
                                <?php print($groups[$i]['groupname']); ?>
                            </div>

                            <?php } ?>
                        </div>

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

                        <label for="country">Country:</label>
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
                                
                        <button class="display form-button" type="submit" name="edituserinfo">Update User Information</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>