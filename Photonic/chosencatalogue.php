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

    $categories = $obj->getallcategoriesdata("categories");
    $brands = $obj->getallbrandsdata("brands");

    // $categories = $obj->getallcategoriesdata("categories");


?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Display Catalogue</title>
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
                                        <p class="signOutButton">Sign Out</p>    
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
                <h1>Product Catalogue</h1>
                <div class="wrapper-container-main">
                    <div class="itemfilter">
                        <h4>Refine Category</h4>
                        <form action="controller.php" method="POST">
                            <div class="searchcategories">
                                <select name="categoryid">
                                    <option value="">Select one</option>
                                    <?php for ($i=0; $i < count($categories); $i++): ?>
                                        <option value="<?=$categories[$i] ['categoryid'];?>"> <?=$categories[$i] ['categorytype']; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button class="display" type="submit" name="categoryident">Search</button>
                            </div>
                        </form>
                        <form id="itemreset" action="displaycatalogue.php">
                            <button class="display" type="submit">Reset</button>
                        </form>
                    </div>
                        
                    <div class="addproduct">
                        <a href="addnewproduct.php">Add Product</a>
                    </div>
                </div>
            </div>

            <div class="table_results">
                <table class="products">
                    <tbody>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock Qty</th>
                            <th scope="col">Features</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Edit</th>
                        </tr>
                        <?php
                            foreach($results as $result){?>
                                <tr>
                                    <td><?php echo $result['id'];?></td>
                                    <td><?php echo $result['code'];?></td>
                                    <td><?php echo $result['name'];?></td>
                                    <td><?php echo $result['price'];?></td>
                                    <td><?php echo $result['stockquantity'];?></td>
                                    <td><?php echo $result['features'];?></td>
                                    <td><?php echo $result['description'];?></td>
                                    <td><?php echo "<img class='image' src=".$result['image']." alt='" . $result['name'] . "'>";?></td>
                                    <td>
                                        <form action="controller.php" class="table_form" method="POST">
                                            <div>
                                                <input type="hidden" name="id" value="<?php echo $result['id'];?>">
                                                <input type="image" src="images/edit.png" name="edit" alt="edit">
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
                        for($x = 1; $x <= $_SESSION['totalPages']; $x++){
                            echo"<a href='?page=$x'>Page $x</a>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>