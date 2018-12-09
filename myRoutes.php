<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/routes.inc.php';
            
?>
    
    <main>
        <div>

            <?php

                if (isset($_SESSION['u_ID'])) {

                    echo '<h1 style="text-align: center;">Pieslēdzies kā pasažieris.</h1>';
                    echo '<div class="pl-3">
                            <a class="btn btn-primary" href=" '.$_SERVER['HTTP_REFERER'].' ">← Atpakaļ</a>
                          </div>';
                    echo '<h1 style="text-align: center;">↓ Mani maršruti. ↓</h1>';

                    $myRoutes = new Routes();
                    $myRoutes->showAllMyCreatedRoutes();
                }

                else {

                    echo '<h1>Pieslēdzieties, lai skatītu savus maršrutus.</h1>';
                }

            ?>

        </div>
    </main>

<?php

    include_once 'footer.php';

?>