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

        $sql = "SELECT * FROM visi_soferu_marsruti JOIN marsruti ON marsruti_ID=ID;";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    // SELECT * FROM visi_soferu_marsruti 
// JOIN marsruti ON marsruti_ID=ID 
// JOIN pilsetas AS p ON no_pilsetas_ID=p.ID
// JOIN valstis AS v ON no_pilsetas_valstis_ID=v.ID

    public function showAllDriverRoutes() {

        $driverRoutes = $this->getAllDriverRoutes();

        if (is_array($driverRoutes)) {

            foreach ($driverRoutes as $driverRoute) {

                echo '<hr>';
                echo '<a class="route" href="route.php?ID='.$driverRoute['ID'].'">';
                echo ' '.$driverRoute['valsts_no'].' ';
            }

        }

    }

}