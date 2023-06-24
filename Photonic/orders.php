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

    // $results = $obj->getallproductdata("products");
    // $categories = $obj->getallcategoriesdata("categories");
    // $brands = $obj->getallbrandsdata("brands");

   
    
    // $results = $obj->getsubsetofallproductdata('products', $start, $rpp);
    $results = $obj->getallorders();
    include 'pagecalculation.php';
    $results = $obj->getsubsetofallorders('userorders', $start, $rpp);
    $_SESSION['noResult'] = "";

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Display Orders</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/catalogue.css">
        <link rel="stylesheet" href="css/orders.css">
        
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
                <h1>Orders</h1>
            </div>
            <!-- <div class="error">
                <p><?=$_SESSION['noResult'];?></p>
            </div> -->
            <div class="table_results">
                <table class="products">
                    <tbody>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Order#</th>
                            <th scope="col">Ordered By</th>
                            <th scope="col">Order Placed</th>
                            <th scope="col">Total Ordered</th>
                            <th scope="col">View</th>
                        </tr>
                        <?php
                            foreach($results as $result){?>
                                <tr>
                                    <td><?php echo "<img class='image' src=".$result['image']." alt='".$result['name']."'>";?></td>
                                    <td><?php echo $result['orderid'];?></td>
                                    <td><?php echo $result['firstname'];?></td>
                                    <td><?php echo $result['orderdate'];?></td>
                                    <td>$<?php echo $result['totalordered'];?></td>
                        
                                    <td>
                                        <form action="controller.php" class="table_form" method="POST">
                                            <div>
                                                <input type="hidden" name="orderid" value="<?php echo $result['orderid'];?>">
                                                <!-- <input type="image" src="images/edit.png" name="vieworder" value="vieworder"> -->
                                                <input type="hidden" name="action" value="vieworder">
                                                <button class="vieworder" type="submit"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <div class="pagelinks">
                            <?php
                                for($x = 1; $x <= $_SESSION['ordertotalPages']; $x++){
                                    echo"<a href='?page=$x'>Page $x</a>";
                                }
                            ?>
                </div>
            </div>
        </div>
    </body>
</html>