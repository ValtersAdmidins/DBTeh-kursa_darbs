<?php

    include_once 'header.php';
            
?>
    
    <main>

        <?php

            if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 1) {

                echo '<h1>Pieslēdzies kā pasažieris.</h1>';

                echo '<a href="newPassengerRoute.php">Izveidot jaunu maršrutu</a><br>';

                echo("{$_SESSION['u_ID']}"."<br />");
                echo("{$_SESSION['u_first']}"."<br />");
                echo("{$_SESSION['u_last']}"."<br />");
                echo("{$_SESSION['u_email']}"."<br />");
                echo("{$_SESSION['u_username']}"."<br />");
                echo("{$_SESSION['u_role']}"."<br />");
            }

            else if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {
                
                echo '<h1>Pieslēdzies kā šoferis.</h1>';

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

    </main>

<?php

    include_once 'footer.php';

?>