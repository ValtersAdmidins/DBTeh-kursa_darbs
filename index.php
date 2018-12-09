<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/routes.inc.php';
    include 'includes/vehicle.inc.php';
            
?>
    
    <main>

        <?php

            if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 1) {

                echo '<h1 style="text-align: center;">Pieslēdzies kā pasažieris.</h1>
                      <div class="col pl-3">
                        <a class="btn btn-primary" href="newPassengerRoute.php">Izveidot jaunu pasažiera maršrutu</a>
                      </div>';

                echo '<h1 style="text-align: center;">↓ Mani maršruti. ↓</h1>';
                $myRoutes = new Routes();
                $myRoutes->showAllMyCreatedRoutes();

                echo '<h1 style="text-align: center;">↓ Visi šoferu maršruti. ↓</h1>';
                $driverRoutes = new Routes();
                $driverRoutes->showAllDriverRoutes();
            }

            else if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {
                
                echo '<h1 style="text-align: center;">Pieslēdzies kā šoferis.</h1>';
                
                $myVehicles = new Vehicles();
                $myVehicles->checkIfUserHasVehicle($_SESSION['u_ID']);

                if (isset($_SESSION['u_vehicle'])) {
                    echo '<div class="col pl-3">
                            <a class="btn btn-primary" href="newDriverRoute.php">Izveidot jaunu šofera maršrutu</a>
                          </div>
                          <div class="col pl-3 my-1">
                            <a class="btn btn-primary" href="newDriverVehicle.php">Pievienot transportlīdzēkli</a>
                          </div>';

                } else {
                    echo '<div class="col pl-3">
                            <a class="btn btn-primary disabled">Izveidot jaunu šofera maršrutu</a>
                            <h4>Pirms variet izveidot šofera maršrutu piereģistrējiet transportlīdzekli.</h4>
                          </div>
                          <div class="col pl-3 my-1">
                            <a class="btn btn-primary" href="newDriverVehicle.php">Pievienot transportlīdzēkli</a>
                          </div>';
                }
                echo '<h1 style="text-align: center;">↓ Mani maršruti. ↓</h1>';
                $myRoutes = new Routes();
                $myRoutes->showAllMyCreatedRoutes();
                
                echo '<h1 style="text-align: center;">↓ Visi pasažieru maršruti. ↓</h1>';
                $passengerRoutes = new Routes();
                $passengerRoutes->showAllPassengerRoutes();
            }

            else if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 3) {

                echo '<h1>Pieslēdzies kā administrators.</h1>';

                echo("{$_SESSION['u_ID']}"."<br />");
                echo("{$_SESSION['u_first']}"."<br />");
                echo("{$_SESSION['u_last']}"."<br />");
                echo("{$_SESSION['u_email']}"."<br />");
                echo("{$_SESSION['u_username']}"."<br />");
                echo("{$_SESSION['u_role']}"."<br />");
            }

            else {

                echo '<h1 style="text-align: center;">Pieslēdzieties, lai skatītu maršrutu sarakstu.</h1>';
            }

        ?>

    </main>

<?php

    include_once 'footer.php';

?>