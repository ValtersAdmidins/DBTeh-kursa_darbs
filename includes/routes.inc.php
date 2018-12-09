<?php

include 'login.inc.php';

class Routes extends Database {

    public function addPassengerRoute($insert_data) {

        $conn = $this->connect();

        $country_from = $this->getNameOfCountryByID($insert_data[1]);
        $city_from = $this->getNameOfCityByID($insert_data[2]);
        $country_to = $this->getNameOfCountryByID($insert_data[3]);
        $city_to = $this->getNameOfCityByID($insert_data[4]);

        if (is_array($country_from) && 
            is_array($city_from) &&
            is_array($country_to) &&
            is_array($city_to)) {
                
            $country_from_name = $country_from['nosaukums'];
            $city_from_name = $city_from['nosaukums'];
            $country_to_name = $country_to['nosaukums'];
            $city_to_name = $city_to['nosaukums'];
        }

        $sql = "INSERT INTO marsruti (no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits)
                VALUES ('$country_from_name', '$city_from_name', '$country_to_name', '$city_to_name', '$insert_data[5]', '$insert_data[6]', '$insert_data[7]', '$insert_data[8]', '$insert_data[9]', 0);";
        $result1 = $conn->query($sql);

        $user_ID = $insert_data[0];
        $route_ID = $conn->insert_id; // Required to get the ID of the last insert
        $isRouteCreator = 1;

        $sql = "INSERT INTO lietotajiem_ir_marsruti (lietotaji_ID, marsruti_ID, irMarsrutaIzveidotajs)
                VALUES ('$user_ID', '$route_ID', $isRouteCreator);";
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

    public function addDriverRoute($insert_data) {

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

        $user_ID = $insert_data[0];
        $route_ID = $conn->insert_id; // Required to get the ID of the last insert
        $isRouteCreator = 1;

        $sql = "INSERT INTO lietotajiem_ir_marsruti (lietotaji_ID, marsruti_ID, irMarsrutaIzveidotajs)
                VALUES ('$user_ID', '$route_ID', $isRouteCreator);";
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

    public function setRouteRelation($user_ID, $route_ID, $isRouteCreator) {

        $sql = "INSERT INTO lietotajiem_ir_marsruti (lietotaji_ID, marsruti_ID, irMarsrutaIzveidotajs)
                VALUES ('$user_ID', '$route_ID', $isRouteCreator);";
        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../index.php?appliedForRoute=success");
            exit();
        }

        else {

            header("Location: ../index.php?appliedForRoute=error");
            exit();
        }
    }

    public function getNameOfCountryByID($country_ID) {

        $sql = "CALL ValstsNosaukumsPecID('$country_ID')";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getNameOfCityByID($city_ID) {

        $sql = "CALL PilsetasNosaukumsPecID('$city_ID')";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getIDOfCountryByName($country_name) {

        $sql = "CALL ValstsIDPecNosaukuma('$country_name')";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    public function getIDOfCityByName($city_name) {

        $sql = "CALL PilsetasIDPecNosaukuma('$city_name')";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    protected function getAllMyCreatedRoutes() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "CALL visiManiIzveidotieMarsruti('$user_ID')";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllMyCreatedRoutes() {

        $myCreatedRoutes = $this->getAllMyCreatedRoutes();

        echo '
            <hr>
            <div class="table-responsive">
                <table class="table">
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
                            <th scope="col">Piedavātā samaksa</th>';

                            if ($_SESSION['u_ID'] == 1) {
                                echo   '<th scope="col">Nepieciešamās sēdvietas</th>';
                            } else if ($_SESSION['u_ID'] == 2) {
                                echo   '<th scope="col">Pieejamās sēdvietas</th>';
                            }

                    echo   '<th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($myCreatedRoutes)) {
            
            echo '<tbody>';

            foreach ($myCreatedRoutes as $myCreatedRoute) {

                if ($myCreatedRoute['irIzpildits'] == 0) {
                    echo '<tr>
                            <td><a class="btn btn-primary route" href="route.php?ID='.$myCreatedRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$myCreatedRoute['no_valsts']. '</td>
                            <td>' .$myCreatedRoute['no_pilseta']. '</td>
                            <td>' .$myCreatedRoute['uz_valsts']. '</td>
                            <td>' .$myCreatedRoute['uz_pilseta']. '</td>
                            <td>' .$myCreatedRoute['no_adrese']. '</td>
                            <td>' .$myCreatedRoute['uz_adrese']. '</td>
                            <td>' .$myCreatedRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myCreatedRoute['cena']. '</td>
                            <td>' .$myCreatedRoute['sedvietas']. '</td>
                            <td><a class="btn btn-primary route" href="process/markingRouteAsCompleted.php?ID='.$myCreatedRoute['ID'].'">Atzīmēt kā izpildītu</a></td>
                            <td><a class="btn btn-primary route" href="editRoute.php?ID='.$myCreatedRoute['ID'].'">Rediģēt maršrutu</a></td>
                            <td><a class="btn btn-primary route" href="process/deletingRoute.php?ID='.$myCreatedRoute['ID'].'">Dzēst maršrutu</a></td>
                          </tr>';
                } else if ($myCreatedRoute['irIzpildits'] == 1) {
                    echo '<tr class="routeCompleted">
                            <td></td>
                            <td>' .$myCreatedRoute['no_valsts']. '</td>
                            <td>' .$myCreatedRoute['no_pilseta']. '</td>
                            <td>' .$myCreatedRoute['uz_valsts']. '</td>
                            <td>' .$myCreatedRoute['uz_pilseta']. '</td>
                            <td>' .$myCreatedRoute['no_adrese']. '</td>
                            <td>' .$myCreatedRoute['uz_adrese']. '</td>
                            <td>' .$myCreatedRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myCreatedRoute['cena']. '</td>
                            <td>' .$myCreatedRoute['sedvietas']. '</td>
                            <td colspan="2">Maršruts atzīmēts kā izpildīts</td>
                            <td><a class="btn btn-primary route" href="process/deletingRoute.php?ID='.$myCreatedRoute['ID'].'">Dzēst maršrutu</a></td>
                          </tr>';
                }
                    
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';

        echo '<br>';
        $this->showMyCreatedRouteCostSum();
        echo '<br>
              <br>';
    }

    protected function getAllMyAppliedToRoutes() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "CALL visiManiPieteiktieMarsruti('$user_ID')";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllMyAppliedToRoutes() {

        $myAppliedToRoutes = $this->getAllMyAppliedToRoutes();

        echo '
            <hr>
            <div class="table-responsive">
                <table class="table">
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
                            <th scope="col">Piedavātā samaksa</th>';

                            if ($_SESSION['u_ID'] == 1) {
                                echo   '<th scope="col">Nepieciešamās sēdvietas</th>';
                            } else if ($_SESSION['u_ID'] == 2) {
                                echo   '<th scope="col">Pieejamās sēdvietas</th>';
                            }

                    echo   '<th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($myAppliedToRoutes)) {
            
            echo '<tbody>';

            foreach ($myAppliedToRoutes as $myAppliedToRoute) {

                if ($myAppliedToRoute['irIzpildits'] == 0) {
                    echo '<tr>
                            <td><a class="btn btn-primary route" href="route.php?ID='.$myAppliedToRoute['ID'].'">Izvēlēties</a></td>
                            <td>' .$myAppliedToRoute['no_valsts']. '</td>
                            <td>' .$myAppliedToRoute['no_pilseta']. '</td>
                            <td>' .$myAppliedToRoute['uz_valsts']. '</td>
                            <td>' .$myAppliedToRoute['uz_pilseta']. '</td>
                            <td>' .$myAppliedToRoute['no_adrese']. '</td>
                            <td>' .$myAppliedToRoute['uz_adrese']. '</td>
                            <td>' .$myAppliedToRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myAppliedToRoute['cena']. '</td>
                            <td>' .$myAppliedToRoute['sedvietas']. '</td>
                            <td><a class="btn btn-danger route" href="process/unapplyingFromRoute.php?ID='.$myAppliedToRoute['ID'].'">Atteikties no maršruta!</a></td>
                            <td colspan="2"></td>
                          </tr>';
                } else if ($myAppliedToRoute['irIzpildits'] == 1) {
                    echo '<tr class="routeCompleted">
                            <td></td>
                            <td>' .$myAppliedToRoute['no_valsts']. '</td>
                            <td>' .$myAppliedToRoute['no_pilseta']. '</td>
                            <td>' .$myAppliedToRoute['uz_valsts']. '</td>
                            <td>' .$myAppliedToRoute['uz_pilseta']. '</td>
                            <td>' .$myAppliedToRoute['no_adrese']. '</td>
                            <td>' .$myAppliedToRoute['uz_adrese']. '</td>
                            <td>' .$myAppliedToRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$myAppliedToRoute['cena']. '</td>
                            <td>' .$myAppliedToRoute['sedvietas']. '</td>
                            <td colspan="2">Maršruts atzīmēts kā izpildīts</td>
                            <td><a class="btn btn-primary route" href="process/rateARoute.php?ID='.$myAppliedToRoute['ID'].'">Novērtēt braucienu!</a></td>
                          </tr>';
                }
                    
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';

        echo '<br>';
        $this->showMyAppliedToRouteCostSum();
        echo '<br>
              <br>';
    }

    protected function getMyCreatedNotCompletedRouteCostSum() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT manaIzveidotoNeizpilditoMarsrutuKopsumma('$user_ID') AS kopsumma";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
    
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function getMyCreatedCompletedRouteCostSum() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT manaIzveidotoIzpilditoMarsrutuKopsumma('$user_ID') AS kopsumma";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
    
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function showMyCreatedRouteCostSum() {

        $costNotCompletedSum = $this->getMyCreatedNotCompletedRouteCostSum();
        $costCompletedSum = $this->getMyCreatedCompletedRouteCostSum();

        if ($_SESSION['u_ID'] == 1) {

            echo '<div class="float-right pr-3">
                    <div class="float-right">
                        Potenciālā samaksa: ' .$costNotCompletedSum['kopsumma']. '
                    </div>
                    <br>
                    <div class="float-right">
                        Samaksāts: ' .$costCompletedSum['kopsumma']. '
                    </div>
                </div>';

        } else if ($_SESSION['u_ID'] == 2) {

            echo '<div class="float-right pr-3">
                    <div class="float-right">
                        Potenciālā peļņa: ' .$costNotCompletedSum['kopsumma']. '
                    </div>
                    <br>
                    <div class="float-right">
                        Nopelnīts: ' .$costCompletedSum['kopsumma']. '
                    </div>
                </div>';
        }
    }

    protected function getMyAppliedToNotCompletedRouteCostSum() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT manaNeizveidotoNeizpilditoMarsrutuKopsumma('$user_ID') AS kopsumma";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
    
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function getMyAppliedToCompletedRouteCostSum() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT manaNeizveidotoIzpilditoMarsrutuKopsumma('$user_ID') AS kopsumma";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
    
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    protected function showMyAppliedToRouteCostSum() {

        $costNotCompletedSum = $this->getMyAppliedToNotCompletedRouteCostSum();
        $costCompletedSum = $this->getMyAppliedToCompletedRouteCostSum();

        if ($_SESSION['u_ID'] == 1) {

            echo '<div class="float-right pr-3">
                    <div class="float-right">
                        Potenciālā samaksa: ' .$costNotCompletedSum['kopsumma']. '
                    </div>
                    <br>
                    <div class="float-right">
                        Samaksāts: ' .$costCompletedSum['kopsumma']. '
                    </div>
                </div>';

        } else if ($_SESSION['u_ID'] == 2) {

            echo '<div class="float-right pr-3">
                    <div class="float-right">
                        Potenciālā peļņa: ' .$costNotCompletedSum['kopsumma']. '
                    </div>
                    <br>
                    <div class="float-right">
                        Nopelnīts: ' .$costCompletedSum['kopsumma']. '
                    </div>
                </div>';
        }
    }

    protected function getAllPassengerRoutes() {

        $sql = "SELECT marsruti.ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits FROM marsruti
                JOIN visi_pasazieru_marsruti ON marsruti_ID=marsruti.ID
                ORDER BY irIzpildits, Izbrauksanas_laiks;";

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
                <table class="table">
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
                            <th scope="col">Nepieciešamās sēdvietas</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($passengerRoutes)) {
            
            echo '<tbody>';

            foreach ($passengerRoutes as $passengerRoute) {

                if ($passengerRoute['irIzpildits'] == 0) {
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
                            <td></td>
                        </tr>';
                } else if ($passengerRoute['irIzpildits'] == 1) {
                    echo '<tr class="routeCompleted">
                            <td></td>
                            <td>' .$passengerRoute['no_valsts']. '</td>
                            <td>' .$passengerRoute['no_pilseta']. '</td>
                            <td>' .$passengerRoute['uz_valsts']. '</td>
                            <td>' .$passengerRoute['uz_pilseta']. '</td>
                            <td>' .$passengerRoute['no_adrese']. '</td>
                            <td>' .$passengerRoute['uz_adrese']. '</td>
                            <td>' .$passengerRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$passengerRoute['cena']. '</td>
                            <td>' .$passengerRoute['sedvietas']. '</td>
                            <td>Maršruts atzīmēts kā izpildīts</td>
                        </tr>';
                }
                    
            }

            echo '</tbody>';
        }

        echo '
            </table>
        </div>';
    }

    protected function getAllDriverRoutes() {

        $sql = "SELECT marsruti.ID, no_valsts, no_pilseta, uz_valsts, uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits FROM marsruti
                JOIN visi_soferu_marsruti ON marsruti_ID=marsruti.ID
                ORDER BY irIzpildits, Izbrauksanas_laiks;";

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
                <table class="table">
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
                        </tr>
                    </thead>';

        if (is_array($driverRoutes)) {
            
            echo '<tbody>';

            foreach ($driverRoutes as $driverRoute) {

                if ($driverRoute['irIzpildits'] == 0) {
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
                            <td></td>
                        </tr>';
                } else if ($driverRoute['irIzpildits'] == 1) {
                    echo '<tr class="routeCompleted">
                            <td></td>
                            <td>' .$driverRoute['no_valsts']. '</td>
                            <td>' .$driverRoute['no_pilseta']. '</td>
                            <td>' .$driverRoute['uz_valsts']. '</td>
                            <td>' .$driverRoute['uz_pilseta']. '</td>
                            <td>' .$driverRoute['no_adrese']. '</td>
                            <td>' .$driverRoute['uz_adrese']. '</td>
                            <td>' .$driverRoute['izbrauksanas_laiks']. '</td>
                            <td>' .$driverRoute['cena']. '</td>
                            <td>' .$driverRoute['sedvietas']. '</td>
                            <td>Maršruts atzīmēts kā izpildīts</td>
                        </tr>';
                }
            }

            echo '</tbody>';
        }

        echo '
            </table>
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

        $userLogin = new Login();
        $creatorUserRoles = $userLogin->getUserRoles($creatorUser['ID']);
        
        $creatorUserVehicle = $this->getRouteVehicle($route['transportlidzekli_ID']);

        echo '<div class="px-3">
                <hr>
              </div>
              <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No valstis</th>
                            <th scope="col">No pilsetas</th>
                            <th scope="col">Uz valsti</th>
                            <th scope="col">Uz pilsetu</th>
                            <th scope="col">No adreses</th>
                            <th scope="col">Uz adresi</th>
                            <th scope="col">Izbraukšanas laiks</th>
                            <th scope="col">Piedavātā samaksa</th>';
                            
                            if (is_array($creatorUserRoles)) {

                                foreach ($creatorUserRoles as $creatorUserRole) {
                    
                                    if ($creatorUserRole['lomas_ID'] == 1) {
                                        echo '<th scope="col">Nepieciešamās sēdvietas</th>';
                                    } else if ($creatorUserRole['lomas_ID'] == 2) {
                                        echo '<th scope="col">Pieejamās sēdvietas</th>';
                                    }
                                }
                                
                            }

                            if ($creatorUser['ID'] != $_SESSION['u_ID']) {
                                echo '<th scope="col"></th>';
                            }
                            
                    echo '
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
                    <td>' .$route['sedvietas']. '</td>';

            if ($creatorUser['ID'] != $_SESSION['u_ID']) {
                echo '<td><a class="btn btn-primary route" href="process/applyingForRoute.php?ID='.$route['ID'].'">Pieteikties maršrutam</a></td>
                </tr>';
            }
            
            echo '</tbody>';
        }

        echo '</table>
            </div>';

        if (is_array($creatorUser)) {

            echo '<div class="px-3">
                    <h1 style="text-align: center;">↓ Informācija par lietotāju ↓</h1>
                    <hr>
                    <h1>Izveidojis lietotājs: '.$creatorUser['lietotajvards'].' </h1>
                    <h2>Vārds: '.$creatorUser['vards'].' </h2>
                    <h2>Uzvārds: '.$creatorUser['uzvards'].' </h2>
                    <h2>E-pasts: '.$creatorUser['epasts'].' </h2>
                    <h2>Telefona numurs: '.$creatorUser['telefona_numurs'].' </h2>
                  </div>';
        }

        if (is_array($creatorUserVehicle)) {

            echo '<div class="px-3">
                    <h1 style="text-align: center;">↓ Informācija par transportlīdzekli ↓</h1>
                    <hr>
                    <h1>Gads: '.$creatorUserVehicle['gads'].' </h1>
                    <h2>Krāsa: '.$creatorUserVehicle['krasa'].' </h2>
                    <h2>Marka: '.$creatorUserVehicle['marka'].' </h2>
                    <h2>Numurzīme: '.$creatorUserVehicle['numura_zime'].' </h2>
                  </div>';
        }

    }

    public function markRouteAsCompleted($route_ID) {

        $sql = "UPDATE marsruti SET irIzpildits=1
                WHERE ID='$route_ID';";
        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../index.php?markedAsCompleted=success");
            exit();
        }

        else {

            header("Location: ../index.php?markedAsCompleted=error");
            exit();
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