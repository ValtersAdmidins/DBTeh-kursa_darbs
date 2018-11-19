<!--    KURSA DARBS DBTeh_2018    -->
<!--    VALTERS ĀDMĪDIŅŠ 3ITB     -->
<!--        17.11.2018            -->
<?php

    include 'includes/database.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DBTeh-uber</title>
    <meta name="Valters Ādmīdiņš" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>

    <header>

        my header

        <div class="login-box">
            <div class="login-box-content">

                <?php

                    session_start();

                    if (isset($_SESSION['u_ID'])) {

                        echo '<form action="process/loggingOut.php" method="POST">
                                <button type="submit" name="submit">Izlogoties</button>
                              </form>';
                    }

                    else {

                        echo '<form action="process/loggingIn.php" method="POST">
                                <input type="text" name="userORemail" placeholder="Lietotājvārds/epasts*">
                                <input type="password" name="password" placeholder="Parole*">
                                <button type="submit" name="submit">Pieslēgties</button>
                              </form>

                          <a href="register.php">Reģistrēties</a>';
                    }


                ?>

            </div>
        </div>


    </header>