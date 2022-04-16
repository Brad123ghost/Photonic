<?php
    if(!isset($_SESSION )) {
        session_start();
    }


    spl_autoload_register(function($class) {
        include_once( 'db.php' );
    });

    
    $obj = new db_photography;

    if(isset($_POST['action']) && ($_POST['action'] === "searchcategory")) {
        $categoryid = $_POST['categoryid'];
        $_SESSION['categoryid'] = $categoryid;

        // print($categoryid);
        // exit();

        $_SESSION['categoryresults'] = $obj->getchosencategorydata($categoryid);
        // print_r($results);
        // exit();
        header("Location: category.php");
        // include 'category.php';
        exit();
    }

    if(isset($_POST['action']) && ($_POST['action'] === "viewallproducts")) {
        $_SESSION['categoryresults'] = $obj->getallproductdata("products");
        // print_r($results);
        // exit();
        header("Location: allproducts.php");
        // include 'category.php';
        exit();
    }

    if(isset($_POST['action']) && ($_POST['action'] === "viewalldepartments")) {
        // $_SESSION['categoryresults'] = $obj->getallproductdata("products");
        // print_r($results);
        // exit();
        header("Location: allproducts.php");
        // include 'category.php';
        exit();
    }
