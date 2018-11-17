<?php

    include_once 'header.php';
            
?>
    
    <main>

        <?php

            echo("{$_SESSION['u_ID']}"."<br />");
            echo("{$_SESSION['u_first']}"."<br />");
            echo("{$_SESSION['u_last']}"."<br />");
            echo("{$_SESSION['u_email']}"."<br />");
            echo("{$_SESSION['u_username']}"."<br />");
            echo("{$_SESSION['u_role']}"."<br />");

        ?>

    </main>

<?php

    include_once 'footer.php';

?>