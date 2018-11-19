<?php

    include_once 'header.php';
    include 'includes/location.inc.php';
?>

<main>

    <?php

        if (isset($_SESSION['u_ID']) && $_SESSION['u_role'] == 1) {

    ?>

    <div class="form-container">

        <form id="passengerRoute" action="process/addingNewPassengerRoute.php" method="POST">

            <h2 style="text-align: center;">Izveidot jaunu maršrutu</h2>

            <fieldset>
                <select id="country_from">
                    <option value="">Izvēlēties valsti</option>
                    <?php

                        $countries = new Location();
                        $countries->showAllCountries();

                    ?>
                </select>
                <select id="city_from">
                    <option value="">Izvēlēlieties valsti vispirms</option>
                    <!-- ajax html option here [js/locationSelection.js] -->
                </select>
            </fieldset>

            <fieldset>
                <select id="country_to">
                    <option value="">Izvēlēties valsti</option>
                    <?php

                        $countries = new Location();
                        $countries->showAllCountries();

                    ?>
                </select>
                <select id="city_to">
                    <option value="">Izvēlēlieties valsti vispirms</option>
                    <!-- ajax html option here [js/locationSelection.js] -->
                </select>
            </fieldset>

            <fieldset>
                <textarea type="text" name="title" placeholder="Your title*" required></textarea>
            </fieldset>

            <fieldset>
                <textarea type="text" name="short_content" placeholder="Your short content*" required></textarea>
            </fieldset>

            <fieldset>
                <textarea type="text" name="full_content" placeholder="Your full content*" required></textarea>
            </fieldset>

            <fieldset>
                <button type="submit" name="submit">Post!</button>
            </fieldset>

        </form>

    </div>
            
    <?php

        }
    
    ?>

</main>

<?php

include_once 'footer.php';

?>