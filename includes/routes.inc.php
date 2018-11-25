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

    protected function getAllDriverRoutes() {

        $sql = "SELECT marsruti.ID, nv.nosaukums AS no_valsts, np.nosaukums AS no_pilseta, uv.nosaukums AS uz_valsts, up.nosaukums AS uz_pilseta, no_adrese, uz_adrese, izbrauksanas_laiks, cena, sedvietas, irIzpildits
                FROM visi_soferu_marsruti
                JOIN marsruti ON marsruti_ID=ID
                JOIN valstis AS nv ON no_pilsetas_valstis_ID=nv.ID
                JOIN pilsetas AS np ON no_pilsetas_ID=np.ID
                JOIN valstis AS uv ON uz_pilsetas_valstis_ID=uv.ID
                JOIN pilsetas AS up ON uz_pilsetas_ID=up.ID;";

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

        if (is_array($driverRoutes)) {

            foreach ($driverRoutes as $driverRoute) {

                echo '<hr>
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
                            <th>Piedavātā cena</th>
                            <th>Pieejamās sēdvietas</th>
                        </tr>
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
                        </tr>
                      </table>';
            }

        }

    }

}