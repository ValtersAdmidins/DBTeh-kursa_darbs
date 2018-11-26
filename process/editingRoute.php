<?php

    session_start();

    if (isset($_POST['submit']) && isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/routes.inc.php';

        $ID = $_POST['ID'];
        $isCompleted = $_POST['isCompleted'];
        $country_from = $_POST['country_from'];
        $city_from = $_POST['city_from'];
        $country_to = $_POST['country_to'];
        $city_to = $_POST['city_to'];
        $address_from = $_POST['address_from'];
        $address_to = $_POST['address_to'];
        $departure_time = $_POST['departure_time'];
        $price = $_POST['price'];
        $seats = $_POST['seats'];

        $update_data = array($ID, $country_from, $city_from, $country_to, $city_to, $address_from, $address_to, $departure_time, $price, $seats, $isCompleted);

        $route = new Routes();
        $route->editARoute($update_data);
    }

    else {

        header("Location: ../index.php");
        exit();
    }