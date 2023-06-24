<?php
    class db_photography {
        private $host = "localhost";
        private $user = "bradley";
        private $db = "photography";
        private $pass = "bradleyadmin";

        private $conn;

        public function __construct() {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
                // print("Connected");
                // exit();
            }
            catch (PDOException $e) {
                print("Unable to connect to the databse");
                exit();
            }
        }

        public function test_input($data){
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            $data = trim($data);
            $data = stripslashes($data);
            return $data;
        }

        // Getting all the product data from the database products table
        public function getallproductdata($table) {
            $sql = "SELECT * FROM $table";
            $q = $this->conn->query($sql) or die("failed query in getallproductdata");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }
            // print_r($results);
            // exit();
            // exit();

            $combinedresults = $this->getproductbrand($results);
            // print($combinedresults);
            // exit();
            $results = $combinedresults;
            return $results;
            exit();
        }

        // Gets the product brands for a product
        public function getproductbrand($results) {
            // print_r($results);
            $countresults = count($results);
            // print($countresults);
            // exit();
            for($i = 0; $i < $countresults; $i++){
                $productid = $results[$i]['id'];
                // print($productid);
                $sql = "SELECT brandid FROM productbrand WHERE productid='$productid'";
                $q = $this->conn->query($sql)or die("failed query in getting current product id brand");
                while($r = $q->fetch(PDO::FETCH_ASSOC)){
                    $brandresults[] = $r;
                }
                // exit();
                $brandid = $brandresults[$i]['brandid'];
                $brandname = $this->getbrandname("brands", $brandid);
        
                // print_r($brandname);
                $combinedresults[] = $results[$i] + $brandname[0];
                // print_r($brandresults[$i]);
                // print_r($brandresults[$i]['brandid']);
                // print("<br>");
                // print("<br>");
                // print($i);
                // $brandid = $brandresults[0]['brandid'];
                // print("<br>");
                // print("<br>");
                // print("Brand id is: " . $brandid);
            }
            // print("<br>");
            // print("<br>");
            // print_r($brandresults[0]);
            // print("<br>");
            // print("<br>");
            
            // // $groupid = $groupresults[]
            
            // print_r($combinedresults);
            // exit();
            return $combinedresults;
            exit;
        }

        // Gets the brand name for the linked brandid and product
        public function getbrandname($table, $brandid) {
            $sql = "SELECT * FROM $table WHERE brandid='$brandid'";
            $q = $this->conn->query($sql);

            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }
            // print_r($results);
            return $results;
            exit();
        }

        // Function which gets all the brand data so you can choose one from adding/editing a product
        public function getallbrandsdata($table) {
            $sql = "SELECT * FROM $table";
            $q = $this->conn->query($sql) or die("failed query in getallbrandsdata");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $brands[] = $r;
            }
            // print_r($brands);
            // exit();
            return $brands;
            exit();
        }

        // Querring the products table and getting the latest 10 products
        public function getlatestproductdata($table) {
            $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 10";
            $q = $this->conn->query($sql) or die("failed query in getallproductdata");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $latestresults[] = $r;
            }
            // print_r($latestresults);
            // exit();
            return $latestresults;
            exit();
        }

        // Gets all categories type
        public function getallcategoriesdata($table) {
            $sql = "SELECT * FROM $table";
            $q = $this->conn->query($sql) or die("failed query in getallcategoriesdata");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $r;
            }
            // print_r($categories);
            // exit();
            return $categories;
            exit();
        }

        // Gets the current product id
        public function getcurrentproductid($table) {
            $sql = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
            $q = $this->conn->query($sql)or die("Failed in getting product id in getcurrentproductid function");
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            // print_r($results);
            // exit();

            $productid = $results[0]['id'];
            return $productid;
            exit();
        }

        // Inserts the data entered into the database
        public function insertproductdata($productcode, $productname, $productprice, $productstock, $productfeature, $productdescription, $targetFilePath, $categorieschosen, $brandchosen) {
            
            try {
                $sql="INSERT INTO products SET code=:code, name=:name, price=:price, stockquantity=:stockquantity, features=:features, description=:description, image=:image";
    
                $q = $this->conn->prepare( $sql );
                $q->execute( array( 'code' => $productcode, 'name' => $productname, 'price' => $productprice, 'stockquantity' => $productstock, 'features' => $productfeature, 'description' => $productdescription, 'image' => $targetFilePath) );
    
                $productid = $this->getcurrentproductid( 'products' );
                // print( "Product ID " . $productid . "<br>" );
                if ( $targetFilePath != null ) {
                    $sql = "UPDATE products SET image=:image WHERE id=:id";
    
                    $q = $this->conn->prepare( $sql );
                    $q->execute( array( 'id' => $productid, 'image' => $targetFilePath ) );
                }
                
                for ($i = 0; $i < sizeof($categorieschosen) ; $i++) {
                    $sql = "INSERT INTO productcategory SET productid=:productid, categoryid=:categoryid";
                    $q = $this->conn->prepare($sql);
                    $q -> execute(array('productid'=>$productid, 'categoryid'=>$categorieschosen[$i]));
                }

                $sql = "INSERT INTO productbrand SET productid=:productid, brandid=:brandid";
                $q = $this->conn->prepare($sql);
                $q -> execute(array('productid'=>$productid, 'brandid'=>$brandchosen));

            } catch(PDOException $e) {
                print('Unable to insert product data');
                exit();
            };
            
            return true;
        }

        // Getting all categories for the add and edit forms
        public function getcurrentcategories($productid) {
            try {
                $sql = "SELECT categoryid FROM productcategory WHERE productid=:productid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('productid' => $productid));
            }

            catch(PDOException $e){
                print("Unable to get current category data");
                exit();
            };

            $selectedCategories = array();
            foreach ($q as $row) {
                $selectedCategories[] = $row['categoryid'];
            }

            // print_r($selectedCategories);
            // exit();

            try {
                $result = $this->conn->query('SELECT categoryid, categorytype FROM categories');
            }

            catch(PDOException $e){
                print("Error fetching list of categories");
                exit();
            };

            foreach ($result as $row) {
                $categories[] = array('categoryid' => $row['categoryid'], 'categorytype' => $row['categorytype'], 'selected' => in_array($row['categoryid'], $selectedCategories));
            };

            // print_r($categories);
            // exit();

            return $categories;
        }

        // Gets the current orderid
        public function getcurrentorderid($table) {
            $sql = "SELECT orderid FROM $table ORDER BY orderid DESC LIMIT 1";
            // print($sql);
            // exit();
            $q = $this->conn->query($sql)or die("Failed in getting current order id in getcurrentorderid function");
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            // print_r($results);
            // exit();

            $currentorderid = $results[0]['orderid'];
            return $currentorderid;
            exit();
        }

        // Gets the product data when you edit 
        public function getthisproductdata($productid, $table) {     
            $sql = "SELECT * FROM products INNER JOIN productbrand ON products.id = productbrand.productid INNER JOIN brands ON productbrand.brandid = brands.brandid WHERE products.id=$productid";
            $q = $this->conn->query($sql) or die("failed query in this product data in getthisproduct function");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }
            // print_r($results);
            // exit();
            return $results;
            exit();
        }

        // Updating an existing product function
        public function updateproductdata($productid, $productcode, $productname, $productprice, $productstock, $productfeature, $productdescription, $targetFilePath, $categorieschosen, $brandchosen){
            try {
                
                $sql="UPDATE products SET code=:code, name=:name, price=:price, stockquantity=:stockquantity, features=:features, description=:description WHERE id=:id";
    
                $q = $this->conn->prepare($sql);
                $q->execute(array('id'=> $productid, 'code' => $productcode, 'name' => $productname, 'price' => $productprice, 'stockquantity' => $productstock, 'features' => $productfeature, 'description' => $productdescription));
    
                if($targetFilePath !== null) {
                    $sql = "UPDATE products SET image=:image WHERE id=:id";
                   
                    $q = $this->conn->prepare($sql);
    
                    $q->execute(array('id'=> $productid, 'image' => $targetFilePath));
                }
    
                $sql = "DELETE FROM productcategory WHERE productid=:productid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('productid'=>$productid));
    
                for($i = 0; $i < count($categorieschosen); $i++){
                    $sql = "INSERT INTO productcategory SET productid=:productid, categoryid=:categoryid";
                    $q = $this->conn->prepare($sql);
                $q->execute(array('productid'=>$productid, 'categoryid'=>$categorieschosen[$i]));
                }

                $sql = "DELETE FROM productbrand WHERE productid=:productid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('productid'=>$productid));

                $sql = "INSERT INTO productbrand SET productid=:productid, brandid=:brandid";
                $q = $this->conn->prepare($sql);
                $q -> execute(array('productid'=>$productid, 'brandid'=>$brandchosen));
            }
             
            catch(PDOException $e){
                print("Unable to update product data");
                exit();
            };
    
            return true;
        }

        // Getting all product data limiting it to display only a few per page
        public function getsubsetofallproductdata($table, $start, $rpp){
            $sql = "SELECT * FROM $table INNER JOIN productbrand ON products.id = productbrand.productid INNER JOIN brands ON productbrand.brandid = brands.brandid LIMIT $start, $rpp";
            $q = $this->conn->query($sql)or die("failed query in getsubsetofallproductdata");
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            // print_r($results);
            // exit();

            return $results;
            exit();

        }

        // Getting all orders limiting it to display only a few per page.
        public function getsubsetofallorders($table, $start, $rpp){
            $sql = "SELECT * FROM userorders INNER JOIN products on userorders.firstproductcode = products.code INNER JOIN users on userorders.userid = users.userid LIMIT $start, $rpp";
            $q = $this->conn->query($sql)or die("failed query in getsubsetofallorders");
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            // print_r($results);
            // exit();

            return $results;
            exit();

        }

        // Function that handles the admin side of category search 
        public function getchosencategorydata($categoryid){
            try {
                $sql = "SELECT * FROM products INNER JOIN productcategory ON products.id = productcategory.productid INNER JOIN categories ON productcategory.categoryid = categories.categoryid WHERE categories.categoryid=:categoryid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('categoryid'=> $categoryid));

                while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $r;
                }

                // print_r($results);
                // exit();

                // print_r($results[0]);
                // print("<br>");
                // print("<br>");
                // print_r($results[1]);
                // print("<br>");
                // print("<br>");
                // print_r($results[2]);
                // print("<br>");
                // print("<br>");
                // exit();
                
                if(empty($results)){
                    $_SESSION['noResult'] = "Your search has no products that are in this category. Displaying all products page.";
                    header("Location: displaycatalogue.php");
                    exit();
                }
                else {
                    return $results;
                    exit();
                }
            }

            catch(PDOException $e){
                print("Unable to get data for this category");
                exit();
            };
        }

        // Gets the chosen category data on the admin side whilst limiting the products displayed
        public function getsubsetofchosencategorydata($categoryid, $start, $rpp){
            try {
                $sql = "SELECT * FROM products INNER JOIN productcategory ON products.id = productcategory.productid INNER JOIN categories ON productcategory.categoryid = categories.categoryid WHERE categories.categoryid=:categoryid LIMIT $start, $rpp";
                $q = $this->conn->prepare($sql);
                $q->execute(array('categoryid'=> $categoryid));

                while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $r;
                }
                // print_r($results);
                // exit();
                
                if(empty($results)){
                    $_SESSION['noResult'] = "Your search has no products that are in this subset in this category. Displaying all products page.";
                    header("Location: displaycatalogue.php");
                    exit();
                }

                else {
                    return $results;
                    exit();
                }
            }

            catch(PDOException $e){
                print("Unable to get data for this category");
                exit();
            }; 
        }

        // Inserts the order title into the database which includes the first product, time, order by and total price of the order.
        // Used to display on orders.php
        public function ordertitlesubmitted($orderid, $userid, $currentdatetime, $firstproductcode, $totalorder) {
            try {
                $sql = "INSERT INTO userorders SET userid=:userid, orderid=:orderid, orderdate=:orderdate, firstproductcode=:firstproductcode, totalordered=:totalordered";
                $q = $this->conn->prepare($sql);
                $q->execute(array('userid'=>$userid, 'orderid'=>$orderid, 'orderdate'=>$currentdatetime, 'firstproductcode'=>$firstproductcode, 'totalordered'=>$totalorder));
            }

            catch(PDOException $e) {
                print("Unable to insert ordertitle");
                exit();
            }
        }

        // Function is used to submit product information of items ordered by a user
        public function productsordered($orderid, $productid, $quantity) {
            try {
                $sql = "INSERT INTO orders SET orderid=:orderid, productid=:productid, quantity=:quantity";
                $q = $this->conn->prepare($sql);
                $q->execute(array('orderid'=>$orderid, 'productid'=>$productid, 'quantity'=>$quantity));

                // print_r($q);
                // exit();

                unset($_SESSION["user_shopping_cart"]);

            }

            catch(PDOException $e) {
                print("Unable to insert orderinformation");
                exit();
            }
            return true;
        }

        // Called to get all orders to be displayed on the orders.php
        public function getallorders() {
            $sql = "SELECT * FROM userorders INNER JOIN products on userorders.firstproductcode = products.code INNER JOIN users on userorders.userid = users.userid";
            $q = $this->conn->query($sql)or die("failed query in getting all orders");
            while($r = $q->fetch(PDO::FETCH_ASSOC)){
                $results[] = $r;
            }
            // print_r($results);
            return $results;
            exit();
        }

        // Allows admin to view individual products in an order
        public function viewcurrentorder($orderid) {
            $sql = "SELECT * FROM orders INNER JOIN products on orders.productid = products.id WHERE orderid=$orderid";
            $q = $this->conn->query($sql)or die("failed query in getting current order");
            
            while($r = $q->fetch(PDO::FETCH_ASSOC)){
                $results[] = $r;
            }
            // print_r($results);
            return $results;
            exit();
        }


        // USER FUNCTIONS

        // Gets all the users from the users table
        public function getallusers() {
            $sql = "SELECT * FROM users";
            $q = $this->conn->query($sql)or die("failed query in getting current password");
            while($r = $q->fetch(PDO::FETCH_ASSOC)){
                $results[] = $r;
            }

            // foreach ($q as $row) {
            //     $printout[] = $row['userid'];
            // }

    

            // print_r($printout);
            // exit();
            // $combinedresults = $this->getusergroup($results);
            // return $combinedresults;
            // for($i = 0; $i < count($printout); $i++){
            //     try {
            //         $sql = "SELECT groupid FROM usergroup WHERE userid=:userid";
            //         $q = $this->conn->prepare($sql);
            //         $q->execute(array('userid' => $printout[$i]));
            //     }
            //     catch(PDOException $e){
            //         print("Unable to get current group data");
            //         exit();
            //     };
    
            //     $testarray = array();
            //     foreach ($q as $row) {
            //         $testarray[] = $row['groupid'];
            //     }
            //     // print_r($selectedGroups);
            //     // exit();
            //     try {
            //         $result = $this->conn->query('SELECT groupid, groupname FROM groups');
            //     }
            //     catch(PDOException $e){
            //         print("Error fetching list of groups");
            //         exit();
            //     };
            //     foreach ($result as $row) {
            //         $groupstest[] = array('groupid' => $row['groupid'], 'groupname' => $row['groupname'], 'selected' => in_array($row['groupid'], $testarray));
            //     };
    
            // }
            // print_r($groupstest);
            // exit();

            // print_r($categories);
            // exit();
            return $results;
            // return $groupstest;
            exit();
            // $_SESSION
        }

        // Gets the current group of the user.
        public function getcurrentgroup($userid) {  
            try {
                $sql = "SELECT groupid FROM usergroup WHERE userid=:userid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('userid' => $userid));
            }

            catch(PDOException $e){
                print("Unable to get current group data");
                exit();
            };

            $selectedGroups = array();
            foreach ($q as $row) {
                $selectedGroups[] = $row['groupid'];
            }

            // print_r($selectedGroups);
            // exit();

            try {
                $result = $this->conn->query('SELECT groupid, groupname FROM groups');
            }

            catch(PDOException $e){
                print("Error fetching list of groups");
                exit();
            };

            foreach ($result as $row) {
                $groups[] = array('groupid' => $row['groupid'], 'groupname' => $row['groupname'], 'selected' => in_array($row['groupid'], $selectedGroups));
            };

            // print_r($categories);
            // exit();

            return $groups;
        }

        // public function getusergroup($results) {
        //     // print_r($results);
        //     $countresults = count($results);
        //     // // // print($countresults);
        //     // // // exit();
        //     for($i = 0; $i < $countresults; $i++){
        //         $userid = $results[$i]['userid'];
        //         // print($userid);
        //         $sql = "SELECT * FROM usergroup WHERE userid='$userid'";
        //         $q = $this->conn->query($sql)or die("failed query in getting current user");
        //         while($r = $q->fetch(PDO::FETCH_ASSOC)){
        //             $groupresults[] = $r;
        //         }

                
        //         $groupid = $groupresults[$i]['groupid'];
        //         // $combinedresults[] = $results[$i] + $groupresults[$i];
        //         $groupname = $this->getgroupname('groups', $groupid);
        //         $combinedresults[] = $results[$i] + $groupname[0];
        //     }
        //     // // $groupid = $groupresults[]
        //     // print_r($combinedresults);
        //     // exit();
        //     return $combinedresults;
        //     exit;
        // }

        // public function getgroupname($table, $groupid) {
        //     $sql = "SELECT * FROM $table WHERE groupid='$groupid'";
        //     $q = $this->conn->query($sql);

        //     while($r = $q->fetch(PDO::FETCH_ASSOC)) {
        //         $results[] = $r;
        //     }
        //     // print_r($results);
        //     return $results;
        //     exit();
        // }

        // Gets the current userid
        public function getcurrentuser($userid) {
            $sql = "SELECT * FROM users INNER JOIN usergroup ON users.userid = usergroup.userid INNER JOIN groups ON usergroup.groupid = groups.groupid WHERE users.userid='$userid'";
            $q = $this->conn->query($sql)or die("failed query in getting current user");
            while($r = $q->fetch(PDO::FETCH_ASSOC)){
                $results[] = $r;
            }
            // print_r($results);
            return $results;
            exit();
            // $_SESSION
        }

        // Function is used to update the userdata from the admin side
        public function updateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country, $groupschosen){
            try {
                $sql="UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, streetadd=:streetadd, city=:city, suburb=:suburb, country=:country WHERE userid=:userid";

                $q = $this->conn->prepare($sql);
                $q->execute(array('userid'=> $userid, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'streetadd' => $streetadd, 'city' => $city, 'suburb' => $suburb, 'country' => $country));

                $sql = "DELETE FROM usergroup WHERE userid=:userid";
                $q = $this->conn->prepare($sql);
                $q->execute(array('userid'=>$userid));

                for($i = 0; $i < count($groupschosen); $i++) {
                    $sql = "INSERT INTO usergroup SET userid=:userid, groupid=:groupid";
                    $q = $this->conn->prepare($sql);
                    $q->execute(array('userid'=>$userid, 'groupid'=>$groupschosen[$i]));
                  }
            }
             
            catch(PDOException $e){
                print("Unable to update user data");
                exit();
            };
            return true;
        }

        // Function is used to update the customers own infomration
        public function customerupdateuserdata($userid, $firstname, $lastname, $email, $streetadd, $city, $suburb, $country){
            try {
                $sql="UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, streetadd=:streetadd, city=:city, suburb=:suburb, country=:country WHERE userid=:userid";

                $q = $this->conn->prepare($sql);
                $q->execute(array('userid'=> $userid, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'streetadd' => $streetadd, 'city' => $city, 'suburb' => $suburb, 'country' => $country));
            }
             
            catch(PDOException $e){
                print("Unable to update user data");
                exit();
            };
            return true;
        }

        // Updates the password
        public function updateuserpassword($userid, $updatepsw) {
            try {
                $sql="UPDATE users SET psw=:psw WHERE userid=:userid";

                $q = $this->conn->prepare($sql);
                $q->execute(array('psw'=>$updatepsw, 'userid'=>$userid));
            }
             
            catch(PDOException $e){
                print("Unable to update user data");
                exit();
            };
            return true;
        }

        // Updates the users address
        public function updateaddress($userid, $address, $suburb, $city, $country) {
            try {
                $sql="UPDATE users SET streetadd=:streetadd, suburb=:suburb, city=:city, country=:country WHERE userid=:userid";

                $q = $this->conn->prepare($sql);
                $q->execute(array('userid'=> $userid, 'streetadd' => $address, 'suburb' => $suburb, 'city' => $city, 'country' => $country));
                
            }
            catch(PDOException $e){
                print("Unable to update user address data");
                exit();
            };
            return true;
        }

        // Gets the latest userid for the signup process
        public function getcurrentuserid($table) {
            $sql = "SELECT userid FROM $table ORDER BY userid DESC LIMIT 1";
            $q = $this->conn->query($sql)or die("Failed in getting user id in getcurrentuserid function");
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            $userid = $results[0]["userid"];
            return $userid;
            exit();
        }

        // Gets the groupid of customer 
        public function setgroupid($table) {
            $sql = "SELECT groupid FROM $table";
            $q = $this->conn->query($sql);

            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            $groupid = $results[1]['groupid'];
            return $groupid;
            exit();
        }

        // Inserts the user information into the database used in the register form
        public function insertUser($firstname, $lastname, $email, $psw) {
            try {
                $sql = "INSERT INTO users SET firstname=:firstname, lastname=:lastname, email=:email, psw=:psw";
                $q = $this->conn->prepare($sql);
                $q->execute(array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'psw'=>$psw));

            }
            
            catch(PDOException $e) {
                print("Unable to register user");
                exit();
            }
            
            try {
                $userid = $this->getcurrentuserid('users');
                $groupid = $this->setgroupid('groups');
                // print_r($groupid);
                $sql = "INSERT INTO usergroup SET userid=:userid, groupid=:groupid";
                $q = $this->conn->prepare($sql);
                $q->execute(array("userid"=>$userid, "groupid"=>$groupid));
            }

            catch(PDOException $e) {
                print("Unable to add usergroup");
                exit();
            }
            return true;
            exit();
        }

        // During signup this functino is called to check whether the same email already exist in the database.
        public function getemail($email) {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $q = $this->conn->query($sql);

            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $r;
            }

            $countemails = count($results);

            if($countemails > 0){
                return true;
                exit();
            }
            return false;
            exit();
        }

        // Checks if the user is logged in to the store or not.
        public function userIsLoggedIn() {
            unset($_SESSION['loginError']);
            unset($_SESSION['loginSuccess']);
            $_SESSION["duplicateEmail"] = false;
            $_SESSION["registration-error"] = false;
            $_SESSION["pswregistration-error"] = false;
            // print("email is: ".$_POST['email']);
            // print("password is: ".$_POST['password']);
            if(isset($_POST['action']) and $_POST['action'] == 'login'){

                if(!isset($_POST['email']) or $_POST['email'] == '' or !isset($_POST['password']) or ($_POST['password'] == '')) {
                    $_SESSION['loginError'] = 'Please fill in both fields';
                    include('account.php');
                    // print($GLOBALS['loginError']);
                    exit();
                }

                $email = $_POST["email"];
                $password= $_POST["password"];
                $results = $this->getcurrentpassword($email);
                $hash = $results[0]["psw"];
                // print($hash);

                if(password_verify($password, $hash)) {
                    if(!isset($_SESSION)){
                        session_start();
                    }
                    $_SESSION['loggedIn'] = TRUE;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $hash;
                    $userid = $this->getuserid('users');
                    $result = $this->getcurrentuser($userid);
                    // print_r($result);
                    // exit();
                    $_SESSION['userid'] = $userid;
                    $_SESSION['username'] = $result[0]['firstname'];
                    // print($_SESSION['userid']);
                    // exit();
                    $_SESSION['userrole'] = $result[0]['groupname'];
                    unset($_SESSION['loginError']);
                    $_SESSION['loginSuccess'] = 'Login was successful';
                    // echo 'Password is valid!';
                    // exit();
                    // include('index.php');
                    header ('Location:index.php');
                    return true;
                }
                else {
                    if(!isset($_SESSION)) {
                        session_start();
                    }
                    unset($_SESSION['loggedIn']);
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    unset($_SESSION['loginSuccess']);
                    $_SESSION['loginError'] = 'The specified email address or password was incorrect.';
                    include('account.php');
                    return true;
                }
            }

            if(isset($_POST['action']) and $_POST['action'] == 'logout') {
                session_start();
                unset($_SESSION['loginError']);
                unset($_SESSION['loginSuccess']);
                unset($_SESSION['loggedIn']);
                unset($_SESSION['username']);
                unset($_SESSION['password']);
                unset($_SESSION['userid']);
                unset($_SESSION['username']);
                unset($_SESSION["user_shopping_cart"]);
                header("Location:index.php");
                exit();
            }

            if(isset($_SESSION['loggedIn'])){
                return true;
            }
            else return false;
            exit();
        }

        // After the user logs into the website it checks whether that specific user has the customer or admin role
        public function userHasRole($groupid){
            // print("user Id is ".$_SESSION['userid']);
            try {
                $sql = "SELECT COUNT(*) FROM usergroup WHERE userid=:userid AND groupid=:groupid";
                $s = $this->conn->prepare($sql);
                $s->execute((array('userid' => $_SESSION['userid'], 'groupid' => $groupid)));
            }

            catch(PDOException $e) {
                $error = "Error searching for usergroups";
                include 'index.php';
                exit();
            }

            $row = $s->fetch();

            if($row[0] > 0) {
                // print("yes");
                return true;
                exit();
            }
            
            else {
                // print("no");
                return false;
                exit();
            }
        }

        // For the login process, this function is called after a succesful logign and gets the userid where the email
        // and password match the ones entered
        public function getuserid($table) {
            try {
                $sql = "SELECT userid FROM $table WHERE email=:email AND psw=:psw";
                $s = $this->conn->prepare($sql);
                $s->execute((array('email'=>$_SESSION['email'], 'psw'=>$_SESSION['password'])));
                while($r = $s->fetch(PDO::FETCH_ASSOC)){
                    $results[]=$r;
                }
                // print_r($s);
                // exit();
                $userid = $results[0]['userid'];

                return $userid;
                exit();
            }

            catch (PDOException $e) {
                $_SESSION['loginError'] = "Could not find this user's id";
                include ('index.php');
                exit();
            }
        }

        // Used in the login part where it gets the current password stored for the email
        // that is currrently trying to login
        public function getcurrentpassword($email) {
            $sql = "SELECT psw FROM users WHERE email ='$email'";
            $q = $this->conn->query($sql)or die("failed query in getting current password");
            while($r = $q->fetch(PDO::FETCH_ASSOC)){
                $results[] = $r;
            }
            if(empty($results)){
                return false;
                exit();
            }
            else {
                return $results;
                exit();
            }
        }


    }

?>