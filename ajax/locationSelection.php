<?php
include '../includes/database.inc.php';
include '../includes/location.inc.php';

if (!empty($_POST['country_from_ID'])) {

    $cities = new Location();
    $cities = $cities->showAllCitiesFromCountry($_POST['country_from_ID']);
}

if (!empty($_POST['country_to_ID'])) {

    $cities = new Location();
    $cities = $cities->showAllCitiesFromCountry($_POST['country_to_ID']);
}