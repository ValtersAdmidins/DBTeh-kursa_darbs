<?php

    if (isset($_POST['submit'])) {

        include '../includes/database.inc.php';
        include '../includes/register.inc.php';

        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repPassword = $_POST['password-repeat'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];

        $insert_data = array($first, $last, $email, $username, $password, $repPassword, $phone, $role);

        $user = new Register();
        $user->registerUser($insert_data);

        header("Location: ../index.php");
    }

    else {

        header("Location: ../register.php");
        exit();
    }