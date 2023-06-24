<?php

if(!isset($_SESSION)){
    session_start();
}

spl_autoload_register(function($class){
    include_once('db.php');
});

$obj = new db_photography;

if(isset($_POST['register'])) {
    $firstname = $obj->test_input($_POST["firstname"]);
    $lastname = $obj->test_input($_POST["lastname"]);
    $email = $obj->test_input($_POST["email"]);
    $psw = $obj->test_input($_POST["psw"]);
    $confirmpsw = $obj->test_input($_POST["confirmpsw"]);

    $registrationdata = array("firstname" => $firstname, "lastname" => $lastname, "email" => $email);

    $_SESSION["duplicateEmail"] = false;
    $_SESSION["registration-error"] = "";
    $_SESSION["registrationerrors"] = array();
    foreach($registrationdata as $key => $value){
        // echo "Key= " . $key . ", Value= " . $value;
        // echo "<br>";

        $reg_variable = "$key-error";
        if($value == "") {
            // $_SESSION["registration-error"] = true;
            array_push($_SESSION["registrationerrors"], $reg_variable);
        }
    }
    // print_r($_SESSION["registrationerrors"]);
    // exit();

    if(count($_SESSION["registrationerrors"]) != 0) {
        $_SESSION["registration-error"] = true;
    }
    else {
        $_SESSION["registration-error"] = false;
    }
    // print(count($_SESSION["registrationerrors"]));
    // print("registrationerror is ".$_SESSION["registration-error"]);
    // exit();

    if($psw == "") {
        $_SESSION["pswregistration-error"] = true;
        $_SESSION["psw-error"] = true;
    }
    else if ($psw != "") {
        $_SESSION["pswregistration-error"] = false;
        unset($_SESSION["psw-error"]);
    }

    if($psw != $confirmpsw) {
        $_SESSION["pswregistration-error"] = true;
        $_SESSION["passwordmatch-error"] = true;
    }
    else if (($psw != "") && ($psw == $confirmpsw)) {
        $_SESSION["pswregistration-error"] = false;
        unset($_SESSION["passwordmatch-error"]);
    }

    // if($_SESSION["registration-error"] == true){
    //     print("Reg error");
    //     exit();
    // }

    if($obj->getemail($email) == true) {
        $_SESSION["registration-error"] = true;
        $_SESSION["duplicateEmail"] = true;
        // print("duplicate email");
        include "account.php";
        exit();
    }

    if(($_SESSION["registration-error"] == true) || ($_SESSION["pswregistration-error"] == true)){
    // if($_SESSION["registration-error"] == true) {
        // print("<br>");
        // print("pswregist: " . $_SESSION["pswregistration-error"]);
        include "account.php";
        exit();
    }
    
    else if(($_SESSION["registration-error"] == false) && ($_SESSION["pswregistration-error"] == false)) {
        // print("No errors exit");
        // print("<br>");
        // print("pswregist: " . $_SESSION["pswregistration-error"]);
        $_SESSION["registration-error"] = false;
        $_SESSION["pswregistration-error"] = false;
        unset($_SESSION["firstname-error"]);
        unset($_SESSION["lastname-error"]);
        $_SESSION["duplicateEmail"] = false;
        unset($_SESSION["suburb-error"]);
        unset($_SESSION["city-error"]);
        unset($_SESSION["email-error"]);
        unset($_SESSION["psw-error"]);
        unset($_POST["firstname"]);
        unset($_POST["lastname"]);
        unset($_POST["email"]);
        unset($_POST["streetadd"]);
        unset($_POST["suburb"]);
        unset($_POST["city"]);

        $psw = password_hash($psw, PASSWORD_BCRYPT);
        $obj->insertUser($firstname, $lastname, $email, $psw);
        header("Location:index.php");
        exit();
    }
}

if(isset($_POST['cancel'])){
    unset($_POST["firstname"]);
    unset($_POST["lastname"]);
    unset($_POST["email"]);
    unset($_POST["registration-error"]);
    unset($_POST["firstname-error"]);
    unset($_POST["lastname-error"]);
    unset($_POST["email-error"]);
    unset($_POST["psw-error"]);

    header("Location:index.php");
    exit();
}
?>