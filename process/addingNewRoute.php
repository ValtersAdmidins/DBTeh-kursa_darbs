<?php

    session_start();

    if (isset($_POST['submit'])) {

        include '../includes/database.inc.php';
        include '../includes/routes.inc.php';

        $user_ID = $_SESSION['u_ID'];
        $vehicle_ID = $_SESSION['vehicle_ID'];
        $country_from = $_POST['country_from'];
        $city_from = $_POST['city_from'];
        $country_to = $_POST['country_to'];
        $city_to = $_POST['city_to'];
        $address_from = $_POST['address_from'];
        $address_to = $_POST['address_to'];
        $departure_time = $_POST['departure_time'];
        $price = $_POST['price'];
        $seats = $_POST['seats'];

        $insert_data = array($user_ID, $vehicle_ID, $country_from, $city_from, $country_to, $city_to, $address_from, $address_to, $departure_time, $price, $seats);

        $route = new Routes();
        $route->addRoute($insert_data);
    }

    else {

        header("Location: ../index.php");
        exit();
    }