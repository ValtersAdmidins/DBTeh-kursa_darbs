<?php

    session_start();

    if (isset($_SESSION['u_ID'])) {

        include '../includes/database.inc.php';
        include '../includes/vehicle.inc.php';

        $vehicle_ID = $_GET['ID'];

        $vehicle = new Vehicles();
        $vehicle->deleteAVehicle($vehicle_ID);
    }

    else {

        header("Location: ../index.php");
        exit();
    }