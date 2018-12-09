<!--    KURSA DARBS DBTeh_2018    -->
<!--    VALTERS ĀDMĪDIŅŠ 3ITB     -->
<!--        14.12.2018            -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DBTeh-uber</title>
    <meta name="Valters Ādmīdiņš" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    
    <!-- Date picker styling -->
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css"/>
</head>
<body>

<div class="content">

    <header>

        <nav class="navbar navbar-light">
            <a class="navbar-brand" href="index.php">Öber</a>
            <div class="ml-auto">

                <?php
                    session_start();

                    if (isset($_SESSION['u_ID'])) {

                        echo '<form class="form-inline" action="process/loggingOut.php" method="POST">
                                <div class="form-group">
                                    <div class="col px-1">
                                        <button class="btn btn-primary" type="submit" name="submit">Izlogoties</button>
                                    </div>
                                </div>
                                </form>';
                    }

                    else {

                        echo '<form class="form-inline" action="process/loggingIn.php" method="POST">
                                <div class="form-group">
                                    <div class="col px-1">
                                        <input type="text" name="userORemail" placeholder="Lietotājvārds/epasts*">
                                    </div>
                                    <div class="col px-1">
                                        <input type="password" name="password" placeholder="Parole*">
                                    </div>
                                    <div class="col px-1">
                                        <button class="btn btn-primary" type="submit" name="submit">Pieslēgties</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-primary float-right" href="register.php">Reģistrēties</a>
                                </div>
                                </form>';
                    }
                ?>

            </div> 
        </nav>

    </header>

