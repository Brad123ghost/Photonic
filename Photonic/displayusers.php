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

    if($obj->userHasRole(1) == false){
        $_SESSION['loginCartError'] = "Only Account Administrators may access the administration pages.";
        header("Location: index.php");
        exit();
    }

    $combinedresults = $obj->getallusers();
    // $groupresults = $obj->getusergroup($results);

    // $categories = $obj->getallcategoriesdata("categories");
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Display Users</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/catalogue.css">
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
        <div class="wrapper">
            <div class="sub-header">
            </div>

            <div class="table_results">
                <table class="products">
                    <tbody>
                        <tr>
                            <th scope="col">User ID</th>
                            <!-- <th scope="col">Role</th> -->
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Street Add</th>
                            <th scope="col">City</th>
                            <th scope="col">Suburb</th>
                            <th scope="col">Country</th>
                            <th scope="col">Edit</th>
                        </tr>

                        <?php
                            foreach($combinedresults as $result){?>
                                <tr>
                                    <td><?php echo $result['userid'];?></td>
                                    <td><?php echo $result['firstname'];?></td>
                                    <td><?php echo $result['lastname'];?></td>
                                    <td><?php echo $result['email'];?></td>
                                    <td><?php echo $result['streetadd'];?></td>
                                    <td><?php echo $result['city'];?></td>
                                    <td><?php echo $result['suburb'];?></td>
                                    <td><?php echo $result['country']?></td>
                                    <td>
                                        <form action="controller.php" class="table_form" method="POST">
                                            <div>
                                                <input type="hidden" name="userid" value="<?php echo $result['userid'];?>">
                                                <input type="image" src="images/edit.png" name="edituser" alt="edituser">
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>