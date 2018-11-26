<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/routes.inc.php';
    include 'includes/location.inc.php';
?>

<main>

    <?php

        if (isset($_SESSION['u_ID'])) {

            $route_ID = $_GET['ID'];
            $route = new Routes();
            $row = $route->getARoute($route_ID);

            $ID = $row['ID'];
            $country_from_name = $row['no_valsts'];
            $city_from_name = $row['no_pilseta'];
            $country_to_name = $row['uz_valsts'];
            $city_to_name = $row['uz_pilseta'];
            $address_from = $row['no_adrese'];
            $address_to = $row['uz_adrese'];
            $departure_time = $row['izbrauksanas_laiks'];
            $price = $row['cena'];
            $seats = $row['sedvietas'];
            $isCompleted = $row['irIzpildits'];
    ?>

    <form id="routeForm" action="process/editingRoute.php" method="POST">

        <h2 style="text-align: center;">Izveidot jaunu pasažiera maršrutu</h2>
        <br>

        <div class="form-group">
            <div class="input-group">
                <input type="hidden" name="ID" value="<?php echo $ID ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input type="hidden" name="isCompleted" value="<?php echo $isCompleted ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="country_from">Valsts no: </label>
            <select id="country_from" name="country_from" required>
                <?php

                    $countries = new Location();
                    $countries->showAllCountries();

                ?>
            </select>

            <label for="city_from">Pilsēta no: </label>
            <select id="city_from" name="city_from" required>
                <!-- ajax html option here [js/locationSelection.js] -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="country_to">Valsts uz: </label>
            <select id="country_to" name="country_to" required>
                <?php

                    $countries = new Location();
                    $countries->showAllCountries();

                ?>
            </select>

            <label for="city_to">Pilsēta uz: </label>
            <select id="city_to" name="city_to" required>
                <!-- ajax html option here [js/locationSelection.js] -->
            </select>
        </div>

        <div class="form-group">
            <label for="address_from">Adresse no: </label>
            <input type="text" name="address_from" placeholder="Adrese no" value="<?php echo $address_from ?>">
            
            <label for="address_to">Adresse uz: </label>
            <input type="text" name="address_to" placeholder="Adrese uz" value="<?php echo $address_to ?>">
        </div>
        
        <div class="form-group">
            <div class="input-group">
                <label for="departure_time">Izbraukšanas laiks: </label>
                <input id="datetimepicker" type="text" name="departure_time" value="<?php echo $departure_time ?>" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="price">Piedāvātā samaksa:</label>
                <input type="number" min="0" name="price" value="<?php echo $price ?>" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="seats">Nepieciešamās sēdvietas: </label>
                <input type="number" min="1" name="seats" value="<?php echo $seats ?>" required>
            </div>
        </div>

        <button type="submit" name="submit">Labot maršrutu!</button>
    </form>
            
    <?php

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>