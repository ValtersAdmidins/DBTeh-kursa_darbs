<!--    KURSA DARBS DBTeh_2018    -->
<!--    VALTERS ĀDMĪDIŅŠ 3ITB     -->
<!--        17.11.2018            -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DBTeh-uber</title>
    <meta name="Valters Ādmīdiņš" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>

<div class="content">

    <header>

        my header

        <nav class="navbar navbar-light">
            <a class="navbar-brand" href="index.php">Home</a>
                <div class="ml-auto">

                    <?php
                        session_start();

                        if (isset($_SESSION['u_ID'])) {

                            echo '
                                <div class="row">

                                    <form action="process/loggingOut.php" method="POST">
                                        <div class="form-group">
                                            <button type="submit" name="submit">Izlogoties</button>
                                        </div>
                                    </form>
                                </div>';
                        }

                        else {

                            echo '
                                <div class="row">
                                    <form action="process/loggingIn.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="userORemail" placeholder="Lietotājvārds/epasts*">
                                            <input type="password" name="password" placeholder="Parole*">
                                            <button type="submit" name="submit">Pieslēgties</button>
                                        </div>
                                    </form>

                                    <div class="form-group">
                                        <a class="float-right" href="register.php">Reģistrēties</a>
                                    </div>
                                </div>';
                        }
                    ?>

                </div>
            </a>  
        </nav>

    </header>

