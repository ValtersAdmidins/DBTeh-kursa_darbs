<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/vehicle.inc.php';
?>

<main>

    <?php

        if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {

    ?>

    <div class="container">
        <h2 style="text-align: center;">Pievienot transportlīdzekli.</h2>
        
        <form id="vehicleForm" action="process/addingNewDriverVehicle.php" method="POST">
        
        <!-- Should get ENUM values from DB in vehicle.inc.php so they are not hard coded in the select options -->

        <div class="form-group">
            <label for="category">Kategorija: </label>
            <select id="category" name="category" required>
                <option value="">Izvēlēties kategoriju*</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        </form>
    </div>
    
            
    <?php

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>