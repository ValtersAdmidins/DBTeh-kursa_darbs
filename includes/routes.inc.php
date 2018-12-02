<?php

class Routes extends Database {

    public function addRoute($insert_data) {

        $conn = $this->connect();

        $country_from = $this->getNameOfCountryByID($insert_data[2]);
        $city_from = $this->getNameOfCityByID($insert_data[3]);
        $country_to = $this->getNameOfCountryByID($insert_data[4]);
        $city_to = $this->getNameOfCityByID($insert_data[5]);

        if (is_array($country_from) && 
            is_array($city_from) &&
            is_array($country_to) &&
            is_array($city_to)) {
                
            $country_from_name = $country_from['nosaukums'];
            $city_from_name = $city_from['nosaukums'];
            $country_to_name = $country_to['nosaukums'];
            $city_to_name = $city_to['nosaukums'];
        }

        $sql = "INSERT INTO marsruti (transportlidzekli_ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits)
                VALUES ('$insert_data[1]', '$country_from_name', '$city_from_name', '$country_to_name', '$city_to_name', '$insert_data[6]', '$insert_data[7]', '$insert_data[8]', '$insert_data[9]', '$insert_data[10]', 0);";
        $result1 = $conn->query($sql);

        $route_ID = $conn->insert_id; // Required to get the ID of the last insert

        $sql = "INSERT INTO lietotajiem_ir_marsruti (lietotaji_ID, marsruti_ID)
                VALUES ('$insert_data[0]', '$route_ID');";
        $result2 = $conn->query($sql);

        if ($result1 && $result2) {

            header("Location: ../index.php?route=success");
            exit();
        }

        else {

            header("Location: ../index.php?route=error");
            exit();
        }
    }

    public function getNameOfCountryByID($country_ID) {

        $sql = "SELECT nosaukums FROM valstis WHERE ID='$country_ID'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getNameOfCityByID($city_ID) {

        $sql = "SELECT nosaukums FROM pilsetas WHERE ID='$city_ID'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getIDOfCountryByName($country_name) {

        $sql = "SELECT ID FROM valstis WHERE nosaukums='$country_name'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getIDOfCityByName($city_name) {

        $sql = "SELECT ID FROM pilsetas WHERE nosaukums='$city_name'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    protected function getAllMyRoutes() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT marsruti.ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits FROM marsruti
                JOIN lietotajiem_ir_marsruti ON marsruti_ID=ID
                WHERE lietotaji_ID='$user_ID'
                ORDER BY ID DESC;";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllMyRoutes() {

        $myRoutes = $this->getAllMyRoutes();

        echo '
            <hr>
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">No valstis</th>
                            <th scope="col">No pilsetas</th>
                            <th scope="col">Uz valsti</th>
                            <th scope="col">Uz pilsetu</th>
                            <th scope="col">No adreses</th>
                            <th scope="col">Uz adresi</th>
                            <th scope="col">Izbraukšanas laiks</th>
                            <th scope="col">Piedavātā samaksa</th>
                            <th scope="col">Pieejamās sēdvietas</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($myRoutes)) {
            
            echo '<tbody>';

            foreach ($myRoutes as $myRoute) {

                    echo '<tr>
                            <td><a class="btn btn-primary route" href="route.php?ID='.$myRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$myRoute['no_valsts']. '</td>
                            <td>' .$myRoute['no_pilseta']. '</td>
                            <td>' .$myRoute['uz_valsts']. '</td>
                            <td>' .$myRoute['uz_pilseta']. '</td>
                            <td>' .$myRoute['no_adrese']. '</td>
                            <td>' .$myRoute['uz_adrese']. '</td>
                            <td>' .$myRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myRoute['cena']. '</td>
                            <td>' .$myRoute['sedvietas']. '</td>
                            <td><a class="btn btn-primary route" href="editRoute.php?ID='.$myRoute['ID'].'">Rediģēt maršrutu</a></td>
                            <td><a class="btn btn-primary route" href="process/deletingRoute.php?ID='.$myRoute['ID'].'">Dzēst maršrutu</a></td>
                        </tr>';
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';
    }

    protected function getAllPassengerRoutes() {

        $sql = "SELECT marsruti.ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits FROM marsruti
                JOIN visi_pasazieru_marsruti ON marsruti_ID=marsruti.ID
                ORDER BY ID DESC;";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllPassengerRoutes() {

        $passengerRoutes = $this->getAllPassengerRoutes();

        echo '
            <hr>
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">No valstis</th>
                            <th scope="col">No pilsetas</th>
                            <th scope="col">Uz valsti</th>
                            <th scope="col">Uz pilsetu</th>
                            <th scope="col">No adreses</th>
                            <th scope="col">Uz adresi</th>
                            <th scope="col">Izbraukšanas laiks</th>
                            <th scope="col">Piedavātā samaksa</th>
                            <th scope="col">Pieejamās sēdvietas</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($passengerRoutes)) {
            
            echo '<tbody>';

            foreach ($passengerRoutes as $passengerRoute) {

                    echo '<tr>
                            <td><a class="btn btn-primary route" href="route.php?ID='.$passengerRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$passengerRoute['no_valsts']. '</td>
                            <td>' .$passengerRoute['no_pilseta']. '</td>
                            <td>' .$passengerRoute['uz_valsts']. '</td>
                            <td>' .$passengerRoute['uz_pilseta']. '</td>
                            <td>' .$passengerRoute['no_adrese']. '</td>
                            <td>' .$passengerRoute['uz_adrese']. '</td>
                            <td>' .$passengerRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$passengerRoute['cena']. '</td>
                            <td>' .$passengerRoute['sedvietas']. '</td>
                        </tr>';
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';
    }

    protected function getAllDriverRoutes() {

        $sql = "SELECT marsruti.ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits FROM marsruti
                JOIN visi_soferu_marsruti ON marsruti_ID=marsruti.ID
                ORDER BY ID DESC;";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllDriverRoutes() {

        $driverRoutes = $this->getAllDriverRoutes();

        echo '
            <hr>
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">No valstis</th>
                            <th scope="col">No pilsetas</th>
                            <th scope="col">Uz valsti</th>
                            <th scope="col">Uz pilsetu</th>
                            <th scope="col">No adreses</th>
                            <th scope="col">Uz adresi</th>
                            <th scope="col">Izbraukšanas laiks</th>
                            <th scope="col">Piedavātā samaksa</th>
                            <th scope="col">Pieejamās sēdvietas</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($driverRoutes)) {
            
            echo '<tbody>';

            foreach ($driverRoutes as $driverRoute) {

                    echo '<tr>
                            <td><a class="btn btn-primary route" href="route.php?ID='.$driverRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$driverRoute['no_valsts']. '</td>
                            <td>' .$driverRoute['no_pilseta']. '</td>
                            <td>' .$driverRoute['uz_valsts']. '</td>
                            <td>' .$driverRoute['uz_pilseta']. '</td>
                            <td>' .$driverRoute['no_adrese']. '</td>
                            <td>' .$driverRoute['uz_adrese']. '</td>
                            <td>' .$driverRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$driverRoute['cena']. '</td>
                            <td>' .$driverRoute['sedvietas']. '</td>
                        </tr>';
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';

    }

    public function getARoute($route_ID) {

        $sql = "SELECT ID, transportlidzekli_ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM marsruti
                WHERE ID='$route_ID';";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function getRouteCreatorUser($route_ID) {

        $sql = "SELECT * FROM lietotaji
                JOIN lietotajiem_ir_marsruti ON lietotaji_ID=ID
                WHERE marsruti_ID='$route_ID';";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function getRouteVehicle($vehicle_ID) {

        $sql = "SELECT * FROM transportlidzekli
                WHERE ID='$vehicle_ID';";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function showARoute($route_ID) {

        $route = $this->getARoute($route_ID);
        $creatorUser = $this->getRouteCreatorUser($route_ID);
        $creatorUserVehicle = $this->getRouteVehicle($route['transportlidzekli_ID']);

        echo '
        <hr>
        <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">No valstis</th>
                        <th scope="col">No pilsetas</th>
                        <th scope="col">Uz valsti</th>
                        <th scope="col">Uz pilsetu</th>
                        <th scope="col">No adreses</th>
                        <th scope="col">Uz adresi</th>
                        <th scope="col">Izbraukšanas laiks</th>
                        <th scope="col">Piedavātā samaksa</th>
                        <th scope="col">Pieejamās sēdvietas</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>';

        if (is_array($route)) {
            
            echo '<tbody>';

            echo '<tr>
                    <td>' .$route['no_valsts']. '</td>
                    <td>' .$route['no_pilseta']. '</td>
                    <td>' .$route['uz_valsts']. '</td>
                    <td>' .$route['uz_pilseta']. '</td>
                    <td>' .$route['no_adrese']. '</td>
                    <td>' .$route['uz_adrese']. '</td>
                    <td>' .$route['izbrauksanas_laiks']. '</td>
                    <td>' .$route['cena']. '</td>
                    <td>' .$route['sedvietas']. '</td>
                </tr>';

            echo '</tbody>';
        }

        echo '</table>
            </div>';

        if (is_array($creatorUser)) {

            echo '
                <hr>
                <h1>Izveidojis lietotājs: '.$creatorUser['lietotajvards'].' </h1>
                <h2>Vārds: '.$creatorUser['vards'].' </h2>
                <h2>Uzvārds: '.$creatorUser['uzvards'].' </h2>
                <h2>E-pasts: '.$creatorUser['epasts'].' </h2>
                <h2>Telefona numurs: '.$creatorUser['telefona_numurs'].' </h2>';
        }

        if (is_array($creatorUserVehicle)) {

            echo '
                <hr>
                <h1>Gads: '.$creatorUsersVehicle['gads'].' </h1>
                <h2>Krāsa: '.$creatorUsersVehicle['krasa'].' </h2>
                <h2>Marka: '.$creatorUsersVehicle['marka'].' </h2>
                <h2>Numurzīme: '.$creatorUsersVehicle['numura_zime'].' </h2>';
        }
        else {
            echo 'SSSSSSSSSSSs';
        }

    }

    public function editARoute($update_data) {

        $country_from = $this->getNameOfCountryByID($update_data[1]);
        $city_from = $this->getNameOfCityByID($update_data[2]);
        $country_to = $this->getNameOfCountryByID($update_data[3]);
        $city_to = $this->getNameOfCityByID($update_data[4]);

        if (is_array($country_from) &&
            is_array($city_from) &&
            is_array($country_to) &&
            is_array($city_to)) {
                
            $country_from_name = $country_from['nosaukums'];
            $city_from_name = $city_from['nosaukums'];
            $country_to_name = $country_to['nosaukums'];
            $city_to_name = $city_to['nosaukums'];
        }

        echo $country_from_name;

        $sql = "UPDATE marsruti SET no_valsts='$country_from_name', 
                                    no_pilseta='$city_from_name', 
                                    uz_valsts='$country_to_name', 
                                    uz_pilseta='$city_to_name',
                                    no_adrese='$update_data[5]', 
                                    uz_adrese='$update_data[6]', 
                                    izbrauksanas_laiks='$update_data[7]', 
                                    cena='$update_data[8]', 
                                    sedvietas='$update_data[9]', 
                                    irIzpildits='$update_data[10]'
                                    WHERE ID='$update_data[0]';";

        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../index.php?edit=success");
            exit();
        }

        else {

            header("Location: ../index.php?edit=error");
            exit();
        }
    }

    public function deleteARoute($route_ID) {

        $sql = "DELETE FROM marsruti WHERE ID='$route_ID'";
        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../index.php?delete=success");
            exit();
        }

        else {

            header("Location: ../index.php?delete=error");
            exit();
        }
    }

}