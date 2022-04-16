<?php
    $rpp = 5;

    // Check for set page
    isset($_GET['page']) ? $page = $_GET['page'] : $page = 0;

    // Calculate the starting position for records we want
    if($page > 1){
        $start = $page * $rpp - $rpp;
    }

    else {
        $start = 0;
    }

    $numRows = count($results);

    // Get total number of pages
    $_SESSION['totalPages'] =  $numRows / $rpp;
    if($numRows % $rpp != 0){
        $_SESSION['totalPages'] += 1;
    }

    $_SESSION['ordertotalPages'] =  $numRows / $rpp;
    if($numRows % $rpp != 0){
        $_SESSION['ordertotalPages'] += 1;
    }