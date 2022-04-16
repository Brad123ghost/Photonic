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
        <title>Photonic Photography | Edit Product</title>
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
            <div class="form-container">
                <h2>Edit Product</h2>
                <p>Update the product Details and click Submit</p>
                <div class="container">
                    <form action="controller.php" class="form" id="form" method="POST" enctype="multipart/form-data">
                        <label for="productid">Current Product ID: <span class="sml-text">(Read Only)</span></label>
                        <input type="text" class="productid" name="productid" id="productid" value="<?php echo $results [0] ['id']; ?>" readonly>

                        <label for="productcode">Enter the Product Code : 
                            <br>
                            <span class="smallText">In the format of (TYPE)-(BRAND)-(NAME)-(ACCESSORIES)</span>
                            <br>
                            <span class="smallText">Example: MIR-CAN-R5-AD</span></label>
                        <input type="text" class="productcode" name="productcode" id="productcode" value="<?php echo $results [0] ['code']; ?>" required>

                        <div class="categories-inner <?php if(($_SESSION["errormsg"]) == true){echo "error";}?>">
                            <p class=categorylabel>Choose all the appropriate categories <span class="smallText">(You must choose at lease one)</span></p>
                            <?php for($i = 0; $i < count($categories); $i++) { ?>
                                <div class="categoriescheckbox">
                                    <input type="checkbox" name="categorieschosen[]" value="<?=($categories[$i] ['categoryid']); ?>"
                                    <?php
                                        if($categories[$i]['selected']) {
                                            echo ' checked';
                                        }
                                    ?>>
                                    <?php print($categories[$i]['categorytype']); ?>
                                </div>

                            <?php } ?>
                        </div>
                        <p class="<?php if($_SESSION["errormsg"] == ture) {echo 'errormsg';}?>">
                            <?php if($_SESSION["errormsg"] == ture) {echo 'Please Choose a Catagory';}?>
                        </p>
                        
                        <div class="container-inner">
                            <p>Choose the Brand <span class="smallText">(Please select one)</span></p>
                            <div class="addbrand">
                                <select name="brandchosen" required>
                                    <option label="--"></option>
                                    <?php for ($i=0; $i < count($brands); $i++): ?>
                                        <option value="<?=$brands[$i] ['brandid'];?>"> <?=$brands[$i] ['brandname']; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <p class="<?php if($_SESSION["branderrormsg"] == ture) {echo 'errormsg';}?>">
                            <?php if($_SESSION["branderrormsg"] == ture) {echo 'Please Choose a Brand';}?>
                        </p>

                        <label for="productname">Enter the Product Name:</label>
                        <input type="text" class="productname" name="productname" id="productname" value="<?php echo $results [0] ['name']; ?>" required>

                        <label for="productprice">Enter the Product Price:</label>
                        <input type="number" min="0" step="0.01" class="productprice" name="productprice" id="productprice" value="<?php echo $results [0] ['price']; ?>" required>

                        <label for="productstock">Enter the Product Stock:</label>
                        <input type="number" min="0" class="productstock" name="productstock" id="productstock" value="<?php echo $results [0] ['stockquantity']; ?>" required>
                        
                        <label for="productdescription">Enter the Products Key Features:</label>
                        <textarea class="productfeature" name="productfeature" id="productfeature" required><?php echo $results [0] ['features'];?></textarea>

                        <label for="productdescription">Enter the Product Description:</label>
                        <textarea class="productdescription" name="productdescription" id="productdescription" required><?php echo $results [0] ['description'];?></textarea>

                        <div class="label">Current image path: <span class="sml-text"><?php echo $results [0] ['image'];?></span></div>
                        <div class="label"><?php echo "<img class='image' src=".$results [0] ['image']." alt='".$results[0]['name']."'>";?></div>
                        <label>Select New Image File to Upload:</label>
                        <input type="file" name="file">

                        <button class="display form-button" type="submit" name="editproduct">Update Product Information</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>