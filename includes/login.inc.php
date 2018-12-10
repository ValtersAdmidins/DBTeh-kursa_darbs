<?php

class Login extends Database {

    public function getUserRoles($user_ID) {

        $sql = "SELECT * FROM lietotajiem_ir_lomas
        JOIN lietotajiem_ir_marsruti ON lietotajiem_ir_marsruti.lietotaji_ID='$user_ID'
        WHERE lietotajiem_ir_lomas.lietotaji_ID='$user_ID' AND lietotajiem_ir_marsruti.lietotaji_ID='$user_ID'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }
    }

    public function loginUser($user_data) {

        session_start();
        $conn = $this->connect();

        $userORemail = $conn->real_escape_string($user_data[0]);
        $password = $conn->real_escape_string($user_data[1]);

        //Error handlers
        //Check if inputs are empty
        if (empty($userORemail) || empty($password)) {

            header("Location: ../index.php?login=empty");
            exit();
        }
        
        else {

            $sql = "SELECT * FROM lietotaji WHERE lietotajvards='$userORemail' OR epasts='$userORemail'";
            $resultUsers = $this->connect()->query($sql);
            $resultCheck = $resultUsers->num_rows;

            if ($resultCheck < 1) {

                header("Location: ../index.php?login=error");
                exit();
            }
            
            else {

                if ($rowUsers = $resultUsers->fetch_assoc()) {
                    
                    //De-hashing the password
                    $hashedPwdCheck = password_verify($password, $rowUsers['parole']);
                    if ($hashedPwdCheck == false) {

                        header("Location: ../index.php?login=error");
                        exit();
                    } 
                    
                    else if ($hashedPwdCheck == true) {

                        //Log in the user here
                        $_SESSION['u_ID'] = $rowUsers['ID'];
                        $_SESSION['u_first'] = $rowUsers['vards'];
                        $_SESSION['u_last'] = $rowUsers['uzvards'];
                        $_SESSION['u_email'] = $rowUsers['epasts'];
                        $_SESSION['u_username'] = $rowUsers['lietotajvards'];

                        $userRoles = $this->getUserRoles($rowUsers['ID']);
                        
                        if (is_array($userRoles)) {

                            foreach ($userRoles as $userRole) {

                                $_SESSION['u_role'] = $userRole['lomas_ID'];
                            }
                            
                        }

                        header("Location: ../index.php?login=success");
                        exit();
                    }

                }

            }

        }

    }

}