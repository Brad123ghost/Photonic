<?php
if(isset($_SESSION['loggedIn'])){
    if(isset($_POST['id']) && $_POST['id'] != ""){
        $id = $_POST['id'];

        // print("The id is ".$id);
        // exit();

        $results = $obj->getthisproductdata($id, "products");
        foreach($results as $row){
            $id = $row['id'];
            $name = $row['name'];
            $code = $row['code'];
            $price = $row['price'];
            $image = $row['image'];
        }

        // print_r($results);
        // print($name);
        // print($code);
        // print($price);
        // print($image);
        // exit();

        $userCartArray = array(
            $code => array(
                'id' => $id,
                'name' => $name,
                'code' => $code,
                'price' => $price,
                'quantity' => 1,
                'image' => $image)           
            );
        
            // print_r($userCartArray);
            // exit();

        if(empty($_SESSION["user_shopping_cart"])){
            $_SESSION["user_shopping_cart"] = $userCartArray;

            // print_r($_SESSION["user_shopping_cart"]);
            // exit();
            $_SESSION["status"] = "<div class='box'>Product has been added to your cart!</div>";
        }

        else {
            // print_r($_SESSION["shopping_cart"]);
            $cart_array_keys = array_keys($_SESSION["user_shopping_cart"]);
            // print("Array Keys");
            // print_r($array_keys);

            if(in_array($code, $cart_array_keys)){
                $_SESSION["status"] = "<div class='box' style='color:red'>Product is already added to your cart!</div>";
            }

            else {
                $_SESSION["user_shopping_cart"] = array_merge($_SESSION["user_shopping_cart"], $userCartArray);

                $_SESSION["status"] = "<div class='box'>Product has been added to your cart!</div>";

                // print_r($_SESSION["shopping_cart"]);
            }
        }
    }
}
