<?php

    session_start();

    if (isset($_POST['submit']) && isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/vehicle.inc.php';

        $ID = $_POST['ID'];
        $category = $_POST['category'];
        $mark = $_POST['mark'];
        $year = $_POST['year'];
        $colour = $_POST['colour'];
        $number_plate = $_POST['number_plate'];

        $update_data = array($ID, $category, $mark, $year, $colour, $number_plate);

        $vehicle = new Vehicles();
        $vehicle->editAVehicle($update_data);
    }

    else {

        header("Location: ../index.php");
        exit();
    }