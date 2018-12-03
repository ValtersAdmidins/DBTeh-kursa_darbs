<?php

class Vehicles extends Database {

    // protected function getAllCategories() {

    //     $sql = "SHOW COLUMNS FROM transportlidzekli WHERE FIELD = kategorija;";
    //     $result = $this->connect()->query($sql);
    //     $numRows = $result->num_rows;

    //     if ($numRows > 0) {

    //         while ($row = $result->fetch_assoc()) {

    //             $data[] = $row;
    //         }

    //         return $data;
    //     }

    // }

    // public function showAllCategories() {
        
    //     $countries = $this->getAllCountries();

    //     if (is_array($countries)) {
            
    //         foreach ($countries as $country) {
                
    //             echo '<option value="'.$country['ID'].'">'.$country['nosaukums'].'</option>';
    //         }

    //     }

    // }

    public function addVehicle($insert_data) {

        $conn = $this->connect();

        $sql = "INSERT INTO transportlidzekli (kategorija, marka, gads, krasa, numura_zime)
                VALUES ('$insert_data[1]', '$insert_data[2]', '$insert_data[3]', '$insert_data[4]', '$insert_data[5]');";
        $result1 = $conn->query($sql);

        $vehicle_ID = $conn->insert_id; // Required to get the ID of the last insert

        $sql = "INSERT INTO lietotajiem_ir_transportlidzekli (lietotaji_ID, transportlidzekli_ID)
                VALUES ('$insert_data[0]', '$vehicle_ID');";
        $result2 = $conn->query($sql);

        if ($result1 && $result2) {

            header("Location: ../newDriverVehicle.php?vehicle=success");
            exit();
        }

        else {

            header("Location: ../newDriverVehicle.php?vehicle=error");
            exit();
        }
    }

    protected function getAllMyVehicles() {

        $user_ID = $_SESSION['u_ID'];
        $sql = "SELECT transportlidzekli.ID, kategorija, marka, gads, krasa, numura_zime FROM transportlidzekli
                JOIN lietotajiem_ir_transportlidzekli ON transportlidzekli_ID=ID
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

    public function showAllMyVehicles() {

        $myVehicles = $this->getAllMyVehicles();
        
        echo '
            <hr>
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Kategorija</th>
                            <th scope="col">Marka</th>
                            <th scope="col">Gads</th>
                            <th scope="col">Krāsa</th>
                            <th scope="col">Numurzīme</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>';

        if (is_array($myVehicles)) {
            
            echo '<tbody>';

            foreach ($myVehicles as $myVehicle) {

                    echo '<tr>
                            <td>' .$myVehicle['kategorija']. '</td>
                            <td>' .$myVehicle['marka']. '</td>
                            <td>' .$myVehicle['gads']. '</td>
                            <td>' .$myVehicle['krasa']. '</td>
                            <td>' .$myVehicle['numura_zime']. '</td>
                            <td><a class="btn btn-primary route" href="editVehicle.php?ID='.$myVehicle['ID'].'">Rediģēt transportlīdzekli</a></td>
                            <td><a class="btn btn-primary route" href="process/deletingVehicle.php?ID='.$myVehicle['ID'].'">Dzēst transportlīdzekli</a></td>
                        </tr>';
            }

            echo '</tbody>';
        }

        echo '</table>
            </div>';
    }

    public function showAllMyVehiclesInForm() {
        
        $vehicles = $this->getAllMyVehicles();
        
        if (is_array($vehicles)) {
            
            foreach ($vehicles as $vehicle) {
                
                echo '<option value="'.$vehicle['ID'].'">'.$vehicle['gads'].' '.$vehicle['krasa'].' '.$vehicle['marka'].' '.$vehicle['numura_zime'].'</option>';
            }

        }

    }

    public function getAVehicle($vehicle_ID) {

        $sql = "SELECT ID, kategorija, marka, gads, krasa, numura_zime
                FROM transportlidzekli
                WHERE ID='$vehicle_ID';";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
        }

    }

    public function editAVehicle($update_data) {

        $sql = "UPDATE transportlidzekli SET kategorija='$update_data[1]', 
                                            marka='$update_data[2]', 
                                            gads='$update_data[3]', 
                                            krasa='$update_data[4]',
                                            numura_zime='$update_data[5]'
                                            WHERE ID='$update_data[0]';";

        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../newDriverVehicle.php?edit=success");
            exit();
        }

        else {

            header("Location: ../newDriverVehicle.php?edit=error");
            exit();
        }
    }

    public function deleteAVehicle($vehicle_ID) {

        $sql = "DELETE FROM transportlidzekli WHERE ID='$vehicle_ID'";
        $result = $this->connect()->query($sql);

        if ($result) {

            header("Location: ../newDriverVehicle.php?delete=success");
            exit();
        }

        else {

            header("Location: ../newDriverVehicle.php?delete=error");
            exit();
        }
    }

    public function checkIfUserHasVehicle($user_ID) {

        $sql = "SELECT transportlidzekli.ID, kategorija, marka, gads, krasa, numura_zime FROM transportlidzekli
                JOIN lietotajiem_ir_transportlidzekli ON transportlidzekli_ID=ID
                WHERE lietotaji_ID='$user_ID'
                ORDER BY ID DESC;";

        $vehicles = $this->connect()->query($sql);
        $numRows = $vehicles->num_rows;

        if ($numRows > 0) {
            
            while ($row = $vehicles->fetch_assoc()) {

                $data[] = $row;
            }

            $_SESSION['u_vehicle'] = $vehicles;
        } else {
            unset($_SESSION['u_vehicle']);
        }
    }
}