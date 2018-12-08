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

            $country_from = $route->getNameOfCountryByID($row['no_valsts']);
            $city_from = $route->getNameOfCityByID($row['no_pilseta']);
            $country_to = $route->getNameOfCountryByID($row['uz_valsts']);
            $city_to = $route->getNameOfCityByID($row['uz_pilseta']); 

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

    <h2 style="text-align: center;">Rediģet maršrutu</h2>

    <div class="container">
        <form id="routeForm" action="process/editingRoute.php" method="POST">

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
                <div class="form-inline">
                    <label class="mr-2" for="country_from">Valsts no: </label>
                    <select id="country_from" class="form-control col" name="country_from" required>
                        <?php

                            $countries = new Location();
                            $countries->showAllCountries($route_ID);

                        ?>
                    </select>
                    <label class="mx-2" for="city_from">Pilsēta no: </label>
                    <select id="city_from" class="form-control col" name="city_from" required>
                        <!-- ajax html option here [js/locationSelection.js] -->
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="form-inline">
                    <label class="mr-2" for="country_to">Valsts uz: </label>
                    <select id="country_to" class="form-control col" name="country_to" required>
                        <?php

                            $countries = new Location();
                            $countries->showAllCountries();

                        ?>
                    </select>

                    <label class="mx-2" for="city_to">Pilsēta uz: </label>
                    <select id="city_to" class="form-control col" name="city_to" required>
                        <!-- ajax html option here [js/locationSelection.js] -->
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="form-inline">
                    <label class="mr-2" for="address_from">Adresse no: </label>
                    <input type="text" maxlength="20" class="form-control col" name="address_from" placeholder="Adrese no" value="<?php echo $address_from ?>">
                    
                    <label class="mx-2" for="address_to">Adresse uz: </label>
                    <input type="text" maxlength="20" class="form-control col" name="address_to" placeholder="Adrese uz" value="<?php echo $address_to ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="departure_time">Izbraukšanas laiks: </label>
                <input id="datetimepicker" type="text" class="form-control col" name="departure_time" value="<?php echo $departure_time ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Piedāvātā samaksa:</label>
                <input type="number" min="0" step=".01" class="form-control col" name="price" value="<?php echo $price ?>" required>
            </div>

            <div class="form-group">
                <?php

                    if ($_SESSION['u_ID'] == 1) {
                        echo '<label for="seats">Nepieciešamās sēdvietas: </label>';
                    } elseif ($_SESSION['u_ID'] == 2) {
                        echo '<label for="seats">Pieejamās sēdvietas: </label>';
                    }

                ?>
                <input type="number" min="1" class="form-control col" name="seats" value="<?php echo $seats ?>" required>
            </div>

            <button class="btn btn-primary" type="submit" name="submit">Rediģēt maršrutu!</button>
        </form>
    </div> 
    <?php

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>