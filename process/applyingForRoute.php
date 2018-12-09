<?php

    session_start();

    if (isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/routes.inc.php';

        $user_ID = $_SESSION['u_ID'];
        $route_ID = $_GET['ID'];
        $isRouteCreator = 0;

        $route = new Routes();
        $route->setRouteRelation($user_ID, $route_ID, $isRouteCreator);
    }

    else {

        header("Location: ../index.php");
        exit();
    }