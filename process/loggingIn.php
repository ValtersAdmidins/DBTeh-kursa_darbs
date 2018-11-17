<?php

    if (isset($_POST['submit'])) {

        include '../includes/database.inc.php';
        include '../includes/login.inc.php';

        $userORemail = $_POST['userORemail'];
        $password = $_POST['password'];

        $user_data = array($userORemail, $password);

        $user = new Login();
        $user->loginUser($user_data);
    }

    else {

        header("Location: ../index.php");
        exit();
    }