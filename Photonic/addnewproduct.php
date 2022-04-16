<?php
    if(!isset($_SESSION)) {
        session_start();
        // $_SESSION["errormsg"] = null;
        // $_SESSION["branderrormsg"] = null;
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
        include 'index.php';
        exit();
    }

    $categories = $obj->getallcategoriesdata("categories");
    $brands = $obj->getallbrandsdata("brands");
?>

<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Photonic Photography | Add New Product</title>
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
            <div class="add-product-container">
                <h2>Add a New Product</h2>
                <p>Enter the details required in the form below.</p>
                <div class="container">
                    <form action="controller.php" class="form" id="form" method="POST" enctype="multipart/form-data">
                        <label for="productcode">Enter the Product Code : 
                            <br>
                            <span class="smallText">In the format of (TYPE)-(BRAND)-(NAME)-(ACCESSORIES)</span>
                            <br>
                            <span class="smallText">Example: MIR-CAN-R5-AD</span></label>
                        <input type="text" class="productcode" name="productcode" id="productcode" value="<?php 
                            if(isset($_POST['productcode'])) {
                                    echo htmlentities($_POST['productcode']);
                                }
                            ?>" required>

                        <div class="container-inner <?php if($_SESSION["errormsg"] == ture) {echo 'error';}?>">
                            <p>Choose all the appropriate categories <span class="smallText">(You must choose at lease one)</span></p>
                            <?php foreach ($categories as $category){ ?>
                                <div class="categoriescheckbox">
                                    <input type="checkbox" name="categorieschosen[]" value="<?=$category['categoryid']; ?>">
                                    <?=$category['categorytype']; ?>
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
                                    <option value="">Select one</option>
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
                        <input type="text" class="productname" name="productname" id="productname" value="<?php 
                            if(isset($_POST['productname'])) {
                                    echo htmlentities($_POST['productname']);
                                }
                            ?>" required>

                        <label for="productprice">Enter the Product Price:</label>
                        <input type="number" min="0" step="0.01" class="productprice" name="productprice" id="productprice" value="<?php 
                            if(isset($_POST['productprice'])) {
                                    echo htmlentities($_POST['productprice']);
                                }
                            ?>" required>

                        <label for="productstock">Enter the Product Stock:</label>
                        <input type="number" min="0" class="productstock" name="productstock" id="productstock" value="<?php 
                            if(isset($_POST['productstock'])) {
                                    echo htmlentities($_POST['productstock']);
                                }
                            ?>" required>
                        
                        <label for="productdescription">Enter the Products Key Features:</label>
                        <textarea class="productfeature" name="productfeature" id="productfeature" required><?php 
                                if(isset($_POST['productfeature'])) {
                                        echo $_POST['productfeature'];
                                 }
                            ?></textarea>

                        <label for="productdescription">Enter the Product Description:</label>
                        <textarea class="productdescription" name="productdescription" id="productdescription" required><?php 
                                if(isset($_POST['productdescription'])) {
                                        echo $_POST['productdescription'];
                                 }
                            ?></textarea>

                        <label>Select Image File to Upload:</label>
                        <input type="file" name="file">
                        <button class="display form-button" type="submit" name="addproduct">Submit Product Information</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>