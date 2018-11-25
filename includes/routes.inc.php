<?php

class Routes extends Database {

    public function addRoute($insert_data) {

        $conn = $this->connect();

        $sql = "INSERT INTO marsruti (no_pilsetas_valstis_ID, no_pilsetas_ID, uz_pilsetas_valstis_ID, uz_pilsetas_ID, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits)
                VALUES ('$insert_data[1]', '$insert_data[2]', '$insert_data[3]', '$insert_data[4]', '$insert_data[5]', '$insert_data[6]', '$insert_data[7]', '$insert_data[8]', '$insert_data[9]', 0);";
        $result1 = $conn->query($sql);

        $route_ID = $conn->insert_id;

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

    protected function getAllMyRoutes() {

        $userID = $_SESSION['u_ID'];
        $sql = "SELECT marsruti.ID, nv.nosaukums AS no_valsts, np.nosaukums AS no_pilseta, uv.nosaukums AS uz_valsts, up.nosaukums AS uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM lietotajiem_ir_marsruti
                JOIN marsruti ON marsruti_ID=ID
                JOIN valstis AS nv ON no_pilsetas_valstis_ID=nv.ID
                JOIN pilsetas AS np ON no_pilsetas_ID=np.ID
                JOIN valstis AS uv ON uz_pilsetas_valstis_ID=uv.ID
                JOIN pilsetas AS up ON uz_pilsetas_ID=up.ID
                WHERE lietotaji_ID='$userID'
                ORDER BY marsruti.ID DESC";

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
            <table style="width:100%">
                <tr>
                    <th></th>
                    <th>No valstis</th>
                    <th>No pilsetas</th>
                    <th>Uz valsti</th>
                    <th>Uz pilsetu</th>
                    <th>No adreses</th>
                    <th>Uz adresi</th>
                    <th>Izbraukšanas laiks</th>
                    <th>Piedavātā samaksa</th>
                    <th>Pieejamās sēdvietas</th>
                </tr>';

        if (is_array($myRoutes)) {

            foreach ($myRoutes as $myRoute) {

                    echo '
                        <tr>
                            <td><a class="route" href="route.php?ID='.$myRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$myRoute['no_valsts']. '</td>
                            <td>' .$myRoute['no_pilseta']. '</td>
                            <td>' .$myRoute['uz_valsts']. '</td>
                            <td>' .$myRoute['uz_pilseta']. '</td>
                            <td>' .$myRoute['no_adrese']. '</td>
                            <td>' .$myRoute['uz_adrese']. '</td>
                            <td>' .$myRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myRoute['cena']. '</td>
                            <td>' .$myRoute['sedvietas']. '</td>
                        </tr>';
                      
            } 

        }

        echo '
            </table>';
    }

    protected function getAllPassengerRoutes() {

        $sql = "SELECT marsruti.ID, nv.nosaukums AS no_valsts, np.nosaukums AS no_pilseta, uv.nosaukums AS uz_valsts, up.nosaukums AS uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM visi_pasazieru_marsruti
                JOIN marsruti ON marsruti_ID=ID
                JOIN valstis AS nv ON no_pilsetas_valstis_ID=nv.ID
                JOIN pilsetas AS np ON no_pilsetas_ID=np.ID
                JOIN valstis AS uv ON uz_pilsetas_valstis_ID=uv.ID
                JOIN pilsetas AS up ON uz_pilsetas_ID=up.ID
                ORDER BY marsruti.ID DESC;";

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
            <table style="width:100%">
                <tr>
                    <th></th>
                    <th>No valstis</th>
                    <th>No pilsetas</th>
                    <th>Uz valsti</th>
                    <th>Uz pilsetu</th>
                    <th>No adreses</th>
                    <th>Uz adresi</th>
                    <th>Izbraukšanas laiks</th>
                    <th>Piedavātā samaksa</th>
                    <th>Pieejamās sēdvietas</th>
                </tr>';

        if (is_array($passengerRoutes)) {

            foreach ($passengerRoutes as $passengerRoute) {

                    echo '
                        <tr>
                            <td><a class="route" href="route.php?ID='.$passengerRoute['ID'].'">Izvēlēties</a></td>
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

        }

        echo '
            </table>';

    }

    protected function getAllDriverRoutes() {

        $sql = "SELECT marsruti.ID, nv.nosaukums AS no_valsts, np.nosaukums AS no_pilseta, uv.nosaukums AS uz_valsts, up.nosaukums AS uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM visi_soferu_marsruti
                JOIN marsruti ON marsruti_ID=ID
                JOIN valstis AS nv ON no_pilsetas_valstis_ID=nv.ID
                JOIN pilsetas AS np ON no_pilsetas_ID=np.ID
                JOIN valstis AS uv ON uz_pilsetas_valstis_ID=uv.ID
                JOIN pilsetas AS up ON uz_pilsetas_ID=up.ID
                ORDER BY marsruti.ID DESC;";

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
            <table style="width:100%">
                <tr>
                    <th></th>
                    <th>No valstis</th>
                    <th>No pilsetas</th>
                    <th>Uz valsti</th>
                    <th>Uz pilsetu</th>
                    <th>No adreses</th>
                    <th>Uz adresi</th>
                    <th>Izbraukšanas laiks</th>
                    <th>Piedavātā samaksa</th>
                    <th>Pieejamās sēdvietas</th>
                </tr>';

        if (is_array($driverRoutes)) {

            foreach ($driverRoutes as $driverRoute) {

                    echo '
                        <tr>
                            <td><a class="route" href="route.php?ID='.$driverRoute['ID'].'">Izvēlēties</a></td>
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

        }

        echo '
            </table>';

    }

    protected function getARoute($route_ID) {

        $sql = "SELECT marsruti.ID, nv.nosaukums AS no_valsts, np.nosaukums AS no_pilseta, uv.nosaukums AS uz_valsts, up.nosaukums AS uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM marsruti
                JOIN valstis AS nv ON no_pilsetas_valstis_ID=nv.ID
                JOIN pilsetas AS np ON no_pilsetas_ID=np.ID
                JOIN valstis AS uv ON uz_pilsetas_valstis_ID=uv.ID
                JOIN pilsetas AS up ON uz_pilsetas_ID=up.ID
                WHERE marsruti.ID='$route_ID';";

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

    public function showARoute($route_ID) {

        $route = $this->getARoute($route_ID);
        $creatorUser = $this->getRouteCreatorUser($route_ID);

        echo '
            <hr>
            <table style="width:100%">
                <tr>
                    <th>No valstis</th>
                    <th>No pilsetas</th>
                    <th>Uz valsti</th>
                    <th>Uz pilsetu</th>
                    <th>No adreses</th>
                    <th>Uz adresi</th>
                    <th>Izbraukšanas laiks</th>
                    <th>Piedavātā samaksa</th>
                    <th>Pieejamās sēdvietas</th>
                </tr>';

        if (is_array($route)) {

            echo '
                <tr>
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
        }

        echo '
            </table>';

        if (is_array($creatorUser)) {

            echo '
                <hr>
                <h1>Izveidojis lietotājs: '.$creatorUser['lietotajvards'].' </h1>
                <h2>Vārds: '.$creatorUser['vards'].' </h2>
                <h2>Uzvārds: '.$creatorUser['uzvards'].' </h2>
                <h2>E-pasts: '.$creatorUser['epasts'].' </h2>
                <h2>Telefona numurs: '.$creatorUser['telefona_numurs'].' </h2>';
        }

    }

}