<?php
    if(!isset($_SESSION )) {
        session_start();
    }


    spl_autoload_register(function($class) {
        include_once( 'db.php' );
    });

    
    $obj = new db_photography;
    
    if($obj->userIsLoggedIn() == FALSE) {
        // print("here after userisloggedin");
        $_SESSION['loginCartError'] = "You must login to be able to proceed.";
        header("Location:index.php");
        exit();
    }

    if(isset($_POST['addproduct'])) {
        extract($_POST);
        unset($_SESSION["errormsg"]);
        unset($_SESSION["brandrmsg"]);
        if(!isset($_POST['categorieschosen'])){
            // print("No Categories");
            $_SESSION["errormsg"] = true;
            include("addnewproduct.php");
            exit();
        }
        $_SESSION["errormsg"] = false;
        $_SESSION["branderrormsg"] = false;
        $categorieschosen = $_POST['categorieschosen'];
        $brandchosen = $_POST['brandchosen'];

        // for ($i = 0; $i < sizeof($categorieschosen); $i++) {
        //     print($categorieschosen[$i]);
        //     $sql = "INSERT INTO productcategory SET productid=:productid, categoryid=:categoryid";
        //     $q = $this->conn->prepare($sql);
        //     $q -> execute(array('productid'=>$productstock, 'categoryid'=>$categorieschosen[$i]));
        // }
        // exit();
        // // print_r($categorieschosen);
        // // exit();


        $productcode = $obj->test_input($_POST["productcode"]);
        $productname = $obj->test_input($_POST["productname"]);
        $productprice = $obj->test_input($_POST["productprice"]);
        $productstock = $obj->test_input($_POST["productstock"]);
        $productfeature = $obj->test_input($_POST["productfeature"]);
        $productdescription = $obj->test_input($_POST["productdescription"]);

        // print("Product Code: " . $productcode . "<br>");
        // print("Product Name: " . $productname . "<br>");
        // print("Product Price: " . $productprice . "<br>");
        // print("Product Stock: " . $productstock . "<br>");
        // print("Product Feature: " . $productfeature . "<br>");
        // print("Description: " . $productdescription . "<br>");

        if(!empty($_FILES ["file"] ["name"])){  
            //Path to where the file is
            $targetDir = "images/products/";
            $fileName = $_FILES["file"]["name"];
            $targetFilePath = $targetDir.$fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // print("FileName is: " . $fileName . "<br>");
            // print("targetFilePath is: " . $targetFilePath . "<br>");
            // print("fileType is: " . $fileType . "<br>");

            $allowTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

            if(in_array ($fileType, $allowTypes)){
                move_uploaded_file($_FILES["file"] ["tmp_name"], $targetFilePath);
            }
        }

        else {
            $targetFilePath = null;
        }

        $obj->insertproductdata($productcode, $productname, $productprice, $productstock, $productfeature, $productdescription, $targetFilePath, $categorieschosen, $brandchosen);
        
        header("Location: displaycatalogue.php");
    }

    if(isset($_POST['edit_x'])){
        $productid = $_POST['id'];
        $categories = $obj->getcurrentcategories($productid);
        $brands = $obj->getallbrandsdata("brands");
        $results = $obj->getthisproductdata($productid, "products");
        include('editproduct.php');
        exit();
    }

    if(isset($_POST['editproduct'])){
        unset($_SESSION["errormsg"]);
        $productid = $_POST['productid'];
        $productcode = $_POST['productcode'];
        $productname = $_POST['productname'];
        $productprice = $_POST['productprice'];
        $productstock = $_POST['productstock'];
        $productfeature = $_POST['productfeature'];
        $productdescription = $_POST['productdescription'];
        $targetFilePath = null;
        $categorieschosen = $_POST['categorieschosen'];
        $brandchosen = $_POST['brandchosen'];

        // print("ID is ". $productid. "<br>");
        // print("Code is ". $productcode. "<br>");
        // print("Name is ". $productname. "<br>");
        // print("Price is ". $productprice. "<br>");
        // print("Stock is ". $productstock. "<br>");
        // print("Feature is ". $productdfeature. "<br>");
        // print("Description is ". $productdescription. "<br>");
        // exit();

        if(!isset($_POST['categorieschosen'])){
            $_SESSION["errormsg"] = true;
            $categories = $obj->getcurrentcategories($productid);
            $results = $obj->getthisproductdata($productid, "products");
            include("editproduct.php");
            exit();
        }

        $_SESSION["errormsg"] = false;

        if(!empty($_FILES ["file"] ["name"])){
    
            //Path to where the file is
            $targetDir = "images/products/";
            $fileName = $_FILES["file"]["name"];
            $targetFilePath = $targetDir.$fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
            // Allow Certain File Formats
            $allowTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
    
            if(in_array ($fileType, $allowTypes)){
                // Upload the file to the correct location in our site
                move_uploaded_file($_FILES["file"] ["tmp_name"], $targetFilePath);
            }
        }
        // exit();
        $obj->updateproductdata($productid, $productcode, $productname, $productprice, $productstock, $productfeature, $productdescription, $targetFilePath, $categorieschosen, $brandchosen);
        
        // include 'displaycatalogue.php';
        header("Location: displaycatalogue.php");

        exit();
    }

    if(isset($_POST['edituser_x'])){
        $userid = $_POST['userid'];
        // print($userid);
        // exit();
        // $categories = $obj->getcurrentcategories($productid);
        $groups = $obj->getcurrentgroup($userid);
        // print_r($groups);
        // exit();
        $results = $obj->getcurrentuser($userid);
        include('edituser.php');
        exit();
    }

    if(isset($_POST['edituserinfo'])){
        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $streetadd = $_POST['streetadd'];
        $city = $_POST['city'];
        $suburb = $_POST['suburb'];
        $country = $_POST['country'];
        $updatepsw = $_POST['updatepsw'];
        $updateconfirmpsw = $_POST['updateconfirmpsw'];
        $groupschosen = $_POST['groupschosen'];
        
        if($updatepsw != "") {
            if($updatepsw != $updateconfirmpsw) {
                $_SESSION["updatepasswordmatch-error"] = true;
                $_SESSION["updatepswadmin-error"] = true;
            }
            else if (($updatepsw != "") && ($updatepsw == $updateconfirmpsw)) {
                $_SESSION["updatepswadmin-error"] = false;
                $_SESSION["updatepasswordmatch-error"] = false;
            }
            
            if( ($_SESSION["updatepswadmin-error"] == true) && ($_SESSION["updatepasswordmatch-error"] = true)){
                $results = $obj->getcurrentuser($userid);
                $groups = $obj->getcurrentgroup($userid);
                include "edituser.php";
                exit();
            }
        
            else if (($_SESSION["updatepswadmin-error"] == false) && $_SESSION["updatepasswordmatch-error"] == false){
                $updatepsw = password_hash($updatepsw, PASSWORD_BCRYPT);
                $obj->updateuserpassword($userid, $updatepsw);
                $obj->updateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country, $groupschosen);

                unset($_SESSION["updatepswradmin-error"]);
                unset($_SESSION["updatepasswordmatch-error"]);
            }
        }
        
        else if ($psw == "") {
            $obj->updateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country, $groupschosen);
            unset($_SESSION["updatepswradmin-error"]) ;
            unset($_SESSION["updatepasswordmatch-error"]);
        }

       

        
        // include 'displaycatalogue.php';
        header("Location: displayusers.php");

        exit();
    }

    if(isset($_POST['customeredituserinfo'])){
        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $streetadd = $_POST['streetadd'];
        $city = $_POST['city'];
        $suburb = $_POST['suburb'];
        $country = $_POST['country'];
        $updatepsw = $_POST['updatepsw'];
        $updateconfirmpsw = $_POST['updateconfirmpsw'];
        
        if($updatepsw != "") {
            if($updatepsw != $updateconfirmpsw) {
                $_SESSION["updatepasswordmatch-error"] = true;
                $_SESSION["updatepswadmin-error"] = true;
            }
            else if (($updatepsw != "") && ($updatepsw == $updateconfirmpsw)) {
                $_SESSION["updatepswadmin-error"] = false;
                $_SESSION["updatepasswordmatch-error"] = false;
            }
            
            if( ($_SESSION["updatepswadmin-error"] == true) && ($_SESSION["updatepasswordmatch-error"] = true)){
                $results = $obj->getcurrentuser($userid);
                include "my-account.php";
                exit();
            }
        
            else if (($_SESSION["updatepswadmin-error"] == false) && $_SESSION["updatepasswordmatch-error"] == false){
                $updatepsw = password_hash($updatepsw, PASSWORD_BCRYPT);
                $obj->updateuserpassword($userid, $updatepsw);
                $obj->customerupdateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country);

                unset($_SESSION["updatepswradmin-error"]);
                unset($_SESSION["updatepasswordmatch-error"]);
            }
        }
        
        else if ($psw == "") {
            $obj->customerupdateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country);
            unset($_SESSION["updatepswradmin-error"]) ;
            unset($_SESSION["updatepasswordmatch-error"]);
        }

       

        $_SESSION['accountstatus'] = true;
        // include 'displaycatalogue.php';
        header("Location: my-account.php");

        exit();
    }

    if(isset($_POST['categoryident'])){
        $categoryid = $_POST['categoryid'];
        $_SESSION['categoryid'] = $categoryid;

        $results = $obj->getchosencategorydata($categoryid);

        // print_r($results);
        // exit();
        
        $categorytype = $_SESSION['results'] [0] ['categorytype'];
        include 'pagecalculation.php';
        $results = $obj->getsubsetofchosencategorydata($categoryid, $start, $rpp);
        // print_r($results);
        // exit();
        $_SESSION['results'] = $results;

        // print_r($results);
        // exit();

        include 'chosencatalogue.php';
        // header("Location: displaycatalogue.php");
        
        exit();

        // include 'chosencatalogue.php';
        // exit();
    }

    if(isset($_GET['page']) && isset($_SESSION['categoryid'])) {
        $categoryid = $_SESSION['categoryid'];
        $_SESSION['categoryid'] = $categoryid;
        $results = $obj->getchosencategorydata($categoryid);
        $categorytype = $_SESSION['results'] [0] ['categorytype'];
        include 'pagecalculation.php';
        $results = $obj->getsubsetofchosencategorydata($categoryid, $start, $rpp);
        $_SESSION['results'] = $results;

        $_SESSION['search'] = true;

        include 'chosencatalogue.php';
        
        exit();
    }

    if(isset($_POST['action']) && ($_POST['action'] === "plus")){
        // print("Shopping Cart before quantity change </br>");
        // print_r($_SESSION["shopping_cart"]);
        // print("</br>");
        foreach($_SESSION["user_shopping_cart"] as & $value){
            if($value['code'] === $_POST['code']){
                $value['quantity'] = $_POST['quantity'] + 1;
                break; // Stops the loop after we've found the product
            }
        }
        // print("Shopping Cart after quantity change </br>");
        // print_r($_SESSION["shopping_cart"]);   
        // exit(); 
        header("Location: cart.php");
        exit();
    }
    if(isset($_POST['action']) && ($_POST['action'] === "minus")){
        // print("Shopping Cart before quantity change </br>");
        // print_r($_SESSION["shopping_cart"]);
        // print("</br>");
        foreach($_SESSION["user_shopping_cart"] as & $value){
            if($value['code'] === $_POST['code']){
                if($value['quantity'] > 1){
    
                    $value['quantity'] = $_POST['quantity'] - 1;
                    
                    break; // Stops the loop after we've found the product
                }
                else if ($value['quantity'] = 1){
                    if(!empty($_SESSION["user_shopping_cart"])){
                        print_r($_SESSION["shopping_cart"]);
                        foreach($_SESSION["user_shopping_cart"] as $key => $value){
                            // print("Key is: ".$key."</br>");
                            // print($key." </br>");
                            if($_POST["code"] == $key){
                                unset($_SESSION["user_shopping_cart"][$key]);
                                $_SESSION['cartstatus']="<div class='box'>Product has been removed from your cart</div>";
                            }
            
                            if(empty($_SESSION["user_shopping_cart"])){
                                $_SESSION['cartstatus'] = "";
                                unset($_SESSION["user_shopping_cart"]);
                            }
                        }
                    }
                }
            }

        }
        // print("Shopping Cart after quantity change </br>");
        // print_r($_SESSION["shopping_cart"]);   
        // exit(); 
        header("Location: cart.php");
        exit();
    }

    // if(isset($_POST['action']) && ($_POST['action'] === "change")){
    //     // print("Shopping Cart before quantity change </br>");
    //     // print_r($_SESSION["shopping_cart"]);
    //     // print("</br>");
    //     foreach($_SESSION["user_shopping_cart"] as & $value){
    //         if($value['code'] === $_POST['code']){
    //             $value['quantity'] = $_POST['quantity'];
    //             break; // Stops the loop after we've found the product
    //         }
    //     }
    //     // print("Shopping Cart after quantity change </br>");
    //     // print_r($_SESSION["shopping_cart"]);   
    //     // exit(); 
    //     include('cart.php');
    //     exit();
    // }

    if(isset($_POST['action']) && ($_POST['action'] === "remove")){
        if(!empty($_SESSION["user_shopping_cart"])){
            // print_r($_SESSION["shopping_cart"]);
            foreach($_SESSION["user_shopping_cart"] as $key => $value){
                // print("Key is: ".$key."</br>");
                // print($key." </br>");
                if($_POST["code"] == $key){
                    unset($_SESSION["user_shopping_cart"][$key]);
                    $_SESSION['cartstatus']="<div class='box message_box'>Product has been removed from your cart</div>";
                }

                if(empty($_SESSION["user_shopping_cart"])){
                    $_SESSION['cartstatus'] = "";
                    unset($_SESSION["user_shopping_cart"]);
                }
            }
        }

        header("Location: cart.php");
        exit();
    }
    // if(isset($_POST['action']) and $_POST['action'] == 'login') {
    //     $obj->userIsLoggedIn();
    // }

    
    if(isset($_POST['action']) && ($_POST['action'] == 'updateaddress')){
        $userid = $_SESSION['userid'];
        $orderid = $_POST['ordernumber'];
        $address = $obj->test_input($_POST["streetadd"]);
        $suburb = $obj->test_input($_POST["suburb"]);
        $city = $obj->test_input($_POST["city"]);
        $country = $obj->test_input($_POST["country"]);

        $updateaddressdata = array("address" => $address, "suburb" => $suburb, "city" => $city, "country" => $country);

        $_SESSION["updateaddress-error"] = "";
        $_SESSION["updateaddresserrors"] = array();
        foreach($updateaddressdata as $key => $value){
            // echo "Key= " . $key . ", Value= " . $value;
            // echo "<br>";

            $reg_variable = "$key-error";
            if($value == "") {
                // $_SESSION["registration-error"] = true;
                array_push($_SESSION["updateaddresserrors"], $reg_variable);
            }
        }

    //     print_r($_SESSION["updateaddresserrors"]);
    // exit();
        if(count($_SESSION["updateaddresserrors"]) != 0) {
            $_SESSION["updateaddress-error"] = true;
        }
        else {
            $_SESSION["updateaddress-error"] = false;
        }

        if($_SESSION["updateaddress-error"] == true) {
            include "shipping.php";
            exit();
        }

        else if($_SESSION["updateaddress-error"] == false && $_SESSION['updateaddresserrors'] == false) {
            $updatedadd = $obj->updateaddress($userid, $address, $suburb, $city, $country);
            // header("Location:index.php");
            $_SESSION["status"] = "";
            // print_r($_SESSION["user_shopping_cart"]);
            $currentdatetime = date("Y-m-d H:i:s");
            // $firstproductid = $_SESSION["user_shopping_cart"];
            if(!function_exists('array_key_first')){
                function array_key_first(array $array){
                    foreach ($array as $key => $value){
                        return $key;
                    }
                }
            }
            $firstproductcode = array_key_first($_SESSION["user_shopping_cart"]);
            $totalorder = $_SESSION['total_price'];
            $ordertitlesubmitted = $obj->ordertitlesubmitted($orderid, $userid, $currentdatetime, $firstproductcode, $totalorder);
            foreach($_SESSION["user_shopping_cart"] as $value){
                // print("<br>");
                // print("Order ID is: " . $orderid);
                // print("<br>");
                // print("Product ID is: " . $value['id']);
                // print("<br>");
                // print("Quantity is: " . $value['quantity']);
                // print("<br>");
                // print("Customer ID is: " . $customerid);
                // print("<br>");
                $productid = $value['id'];
                $quantity = $value['quantity'];
                $productsordered = $obj->productsordered($orderid, $productid, $quantity);
            }
            if($productsordered){
                $_SESSION["status"] = "<div class='box box_green'>Your order has been successfully submitted.</div>";
                // include('cart.php');
                header("Location: index.php");
                exit();
            }
        }

    }

    if(isset($_POST['action']) && ($_POST['action'] == 'shipping')){
        $userid = $_SESSION['userid'];
        $userdata = $obj->getcurrentuser($userid);
        $_SESSION['currentaddress'] = $userdata[0]['streetadd'];
        $_SESSION['currentcity'] = $userdata[0]['city'];
        $_SESSION['currentsuburb'] = $userdata[0]['suburb'];
        $_SESSION['currentcountry'] = $userdata[0]['country'];

        if(empty($_SESSION["user_shopping_cart"])){
            $_SESSION["status"] = "<div class='box'>You cannot submit an order with no products.</div>";
            header("location:cart.php");
            exit();
        }

        else{
            if(empty($_SESSION['currentaddress']) || empty($_SESSION['currentcity']) || empty($_SESSION['currentsuburb']) || empty($_SESSION['currentcountry'])){
                $_SESSION['emptyaddresserror'] = true;
            }
            else if (!empty($_SESSION['currentaddress']) & !empty($_SESSION['currentcity']) & !empty($_SESSION['currentsuburb']) & !empty($_SESSION['currentcountry'])){
                unset($_SESSION['emptyaddresserror']);
            }
            // print_r($_SESSION['emptyaddresserror']);
            // echo($userdata);
            include 'shipping.php';
            exit();
        }

    }
    // if(isset($_POST['action']) && ($_POST['action'] == 'submitorder')){
    //     $orderid = $_POST['ordernumber'];
    //     $userid = $_SESSION['userid'];
        
    //     $address = $obj->test_input($_POST["streetadd"]);
    //     $suburb = $obj->test_input($_POST["suburb"]);
    //     $city = $obj->test_input($_POST["city"]);
    //     $country = $obj->test_input($_POST["country"]);
    //     $updatedadd = $obj->updateaddress($userid, $address, $suburb, $city, $country);
    //     // exit();
    //     $userdata = $obj->getcurrentuser($userid);
    //     $currentaddress = $userdata[0]['streetadd'];
    //     $currentcity = $userdata[0]['city'];
    //     $currentsuburb = $userdata[0]['suburb'];
    //     $currentcountry = $userdata[0]['country'];

    //     if(empty($currentaddress) || empty($currentcity) || empty($currentsuburb) || empty($currentcountry)){
    //         include 'shipping.php';
    //         print_r($userdata);
    //         exit();
    //     }

    //     else {
    //         print("Success");
    //         exit();
    //     }



    //     // echo date("Y-m-d H:i:s");
    //     // print_r($_SESSION['user_shopping_cart']);
    //     // exit;
    //     if(empty($_SESSION["user_shopping_cart"])){
    //         $_SESSION["status"] = "<div class='box'>You cannot submit an order with no products.</div>";
    //     }

    //     else {
    //         $_SESSION["status"] = "";
    //         // print_r($_SESSION["user_shopping_cart"]);
    //         $currentdatetime = date("Y-m-d H:i:s");
    //         // $firstproductid = $_SESSION["user_shopping_cart"];
    //         if(!function_exists('array_key_first')){
    //             function array_key_first(array $array){
    //                 foreach ($array as $key => $value){
    //                     return $key;
    //                 }
    //             }
    //         }
    //         $firstproductcode = array_key_first($_SESSION["user_shopping_cart"]);
    //         $totalorder = $_SESSION['total_price'];
    //         $ordertitlesubmitted = $obj->ordertitlesubmitted($orderid, $userid, $currentdatetime, $firstproductcode, $totalorder);
    //         foreach($_SESSION["user_shopping_cart"] as $value){
    //             // print("<br>");
    //             // print("Order ID is: " . $orderid);
    //             // print("<br>");
    //             // print("Product ID is: " . $value['id']);
    //             // print("<br>");
    //             // print("Quantity is: " . $value['quantity']);
    //             // print("<br>");
    //             // print("Customer ID is: " . $customerid);
    //             // print("<br>");
    //             $productid = $value['id'];
    //             $quantity = $value['quantity'];
    //             $productsordered = $obj->productsordered($orderid, $productid, $quantity);
    //         }
    //     }

    //     if($productsordered){
    //         $_SESSION["status"] = "<div class='box box_green'>Your order has been successfully submitted.</div>";
    //         include('cart.php');
    //         exit();
    //     }

        
    // }

    if(isset($_POST['action']) && ($_POST['action'] == 'vieworder')){
        $orderid = $_POST['orderid'];
        $_SESSION['orderid'] = $orderid;
        // print($orderid);
        // print("test");
        // exit();
        // $categories = $obj->getcurrentcategories($productid);
        $results = $obj->viewcurrentorder($orderid);
        include('vieworder.php');
        exit();
    }