<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/routes.inc.php';
            
?>
    
    <main>
        <div>

            <?php

                if (isset($_GET['ID']) && isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 1) {

                    $route_ID = $_GET['ID'];

                    echo '<h1 style="text-align: center;">Pieslēdzies kā pasažieris.</h1>';
                    echo '<a href="myRoutes.php" >← Atpakaļ</a>';

                    echo '<h1 style="text-align: center;">↓ Maršruts ↓</h1>';

                    $route = new Routes();
                    $route->showARoute($route_ID);
                }

                elseif (isset($_GET['ID']) && isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {

                    $route_ID = $_GET['ID'];

                    echo '<h1 style="text-align: center;">Pieslēdzies kā šoferis.</h1>';
                    echo '<a href="index.php" >← Atpakaļ</a>';

                    echo '<h1 style="text-align: center;">↓ Maršruts ↓</h1>';

                    $route = new Routes();
                    $route->showARoute($route_ID);
                }

                else {

                    echo '<h1>Pieslēdzieties, lai skatītu maršrutus.</h1>';
                }

            ?>

        </div>
    </main>

<?php

    include_once 'footer.php';

?>