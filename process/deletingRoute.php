<?php

    session_start();

    if (isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/routes.inc.php';

        $route_ID = $_GET['ID'];

        $route = new Routes();
        $route->deleteARoute($route_ID);
    }

    else {

        header("Location: ../index.php");
        exit();
    }