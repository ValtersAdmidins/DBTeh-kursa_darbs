<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/routes.inc.php';
            
?>
    
    <main>
        <div>

            <?php

                if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 1) {

                    echo '<h1 style="text-align: center;">Pieslēdzies kā pasažieris.</h1>';
                    echo '<a href="newPassengerRoute.php">Izveidot jaunu pasažiera maršrutu</a><br>';

                    echo("{$_SESSION['u_ID']}"."<br />");
                    echo("{$_SESSION['u_first']}"."<br />");
                    echo("{$_SESSION['u_last']}"."<br />");
                    echo("{$_SESSION['u_email']}"."<br />");
                    echo("{$_SESSION['u_username']}"."<br />");
                    echo("{$_SESSION['u_role']}"."<br />");

                    echo '<h1 style="text-align: center;">↓ Visi šoferu maršruti. ↓</h1>';

                    $driverRoutes = new Routes();
                    $driverRoutes->showAllDriverRoutes();
                }

                else if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {
                    
                    echo '<h1>Pieslēdzies kā šoferis.</h1>';
                    echo '<a href="newDriverRoute.php">Izveidot jaunu šofera maršrutu</a><br>';

                    echo("{$_SESSION['u_ID']}"."<br />");
                    echo("{$_SESSION['u_first']}"."<br />");
                    echo("{$_SESSION['u_last']}"."<br />");
                    echo("{$_SESSION['u_email']}"."<br />");
                    echo("{$_SESSION['u_username']}"."<br />");
                    echo("{$_SESSION['u_role']}"."<br />");
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

                    echo '<h1>Pieslēdzieties, lai skatītu maršrutu sarakstu.</h1>';
                }

            ?>

        </div>
    </main>

<?php

    include_once 'footer.php';

?>