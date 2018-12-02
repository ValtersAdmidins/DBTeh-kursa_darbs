<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/vehicle.inc.php';
?>

<main>

    <?php

        if (isset($_SESSION['u_ID'])) {

            $vehicle_ID = $_GET['ID'];
            $vehicle = new Vehicles();
            $row = $vehicle->getAVehicle($vehicle_ID);

            $ID = $row['ID'];
            $category = $row['kategorija'];
            $mark = $row['marka'];
            $year = $row['gads'];
            $colour = $row['krasa']; 
            $number_plate = $row['numura_zime'];
    ?>

    <div class="container">
        <h2 style="text-align: center;">Pievienot transportlīdzekli.</h2>
        <form id="vehicleForm" action="process/editingVehicle.php" method="POST">
        
        <div class="form-group">
            <input type="hidden" name="ID" value="<?php echo $ID ?>">
        </div>

        <!-- Should get ENUM values from DB in vehicle.inc.php so they are not hard coded in the select options -->

        <div class="form-group">
            <label for="category">Kategorija:</label>
            <select id="category" class="form-control" name="category" required>
                <option value="<?php echo $category ?>" hidden selected> <?php echo $category ?> </option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        <div class="form-group">
            <label for="mark">Marka:</label>
            <input type="text" class="form-control" name="mark" placeholder="Marka" value="<?php echo $mark ?>" required>
        </div>

        <div class="form-group">
            <label for="year">Gads:</label>
            <input type="number" class="form-control" name="year" placeholder="e.g. 1997" value="<?php echo $year ?>" required>
        </div>

        <div class="form-group">
            <label for="colour">Krāsa:</label>
            <input type="text" class="form-control" name="colour" placeholder="Krāsa" value="<?php echo $colour ?>" required>
        </div>

        <div class="form-group">
            <label for="number_plate">Numurzīme:</label>
            <input type="text" class="form-control" name="number_plate" placeholder="Numurzīme" value="<?php echo $number_plate ?>" required>
        </div>

        <button class="btn btn-primary" type="submit" name="submit">Rediģēt transportlīdzekli!</button>

        </form>
    </div>
    
            
    <?php

        echo '<h1 style="text-align: center;">↓ Mani transportlīdzekļi. ↓</h1>';

        $myVehicles = new Vehicles();
        $myVehicles->showAllMyVehicles();

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>