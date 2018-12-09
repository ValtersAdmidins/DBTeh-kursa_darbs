<?php

    session_start();

    if (isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/routes.inc.php';

        $user_ID = $_SESSION['u_ID'];
        $route_ID = $_GET['ID'];

        $route = new Routes();
        $route->unapplyFromRoute($user_ID, $route_ID);
    }

    else {

        header("Location: ../index.php");
        exit();
    }