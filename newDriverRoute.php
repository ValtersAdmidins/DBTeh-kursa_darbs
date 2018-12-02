<?php

    include_once 'header.php';
    include 'includes/database.inc.php';
    include 'includes/location.inc.php';
?>

<main>

    <?php

        if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 2) {

    ?>

    <h2 style="text-align: center;">Izveidot jaunu šofera maršrutu</h2>
    
    <form id="routeForm" action="process/addingNewRoute.php" method="POST">

        <div class="form-group">
            <label for="country_from">Valsts no: </label>
            <select id="country_from" name="country_from" required>
                <option value="">Izvēlēties valsti*</option>
                <?php

                    $countries = new Location();
                    $countries->showAllCountries();

                ?>
            </select>

            <label for="city_from">Pilsēta no: </label>
            <select id="city_from" name="city_from" required>
                <option value="">Izvēlēlieties valsti vispirms*</option>
                <!-- ajax html option here [js/locationSelection.js] -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="country_to">Valsts uz: </label>
            <select id="country_to" name="country_to" required>
                <option value="">Izvēlēties valsti*</option>
                <?php

                    $countries = new Location();
                    $countries->showAllCountries();

                ?>
            </select>

            <label for="city_to">Pilsēta uz: </label>
            <select id="city_to" name="city_to" required>
                <option value="">Izvēlēlieties valsti vispirms*</option>
                <!-- ajax html option here [js/locationSelection.js] -->
            </select>
        </div>

        <div class="form-group">
            <label for="address_from">Adresse no: </label>
            <input type="text" name="address_from" placeholder="Adrese no">
            
            <label for="address_to">Adresse uz: </label>
            <input type="text" name="address_to" placeholder="Adrese uz">
        </div>
        
        <div class="form-group">
            <div class="input-group">
                <label for="departure_time">Izbraukšanas laiks: </label>
                <input id="datetimepicker" type="text" name="departure_time" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="price">Piedāvātā samaksa:</label>
                <input type="number" min="0" name="price">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <label for="seats">Pieejamās sēdvietas: </label>
                <input type="number" min="1" name="seats">
            </div>
        </div>

        <button type="submit" name="submit">Izveidot maršrutu!</button>
    </form>
            
    <?php

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>