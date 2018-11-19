<?php

class Register extends Database {

    public function registerUser($insert_data) {
        
        $conn = $this->connect();

        $first = $conn->real_escape_string($insert_data[0]);
        $last = $conn->real_escape_string($insert_data[1]);
        $email = $conn->real_escape_string($insert_data[2]);
        $username = $conn->real_escape_string($insert_data[3]);
        $password = $conn->real_escape_string($insert_data[4]);
        $repPassword = $conn->real_escape_string($insert_data[5]);
        $phone = $conn->real_escape_string($insert_data[6]);
        $role = $conn->real_escape_string($insert_data[7]);

        // Error handlers
        // Check for empty fields
        if (empty($first) || empty($last) || empty($email) || empty($username) || empty($password) || empty($repPassword) || empty($phone) || empty($role)) {

            header("Location: ../register.php?register=empty");
            exit();
        }

        else {

            // Check if input characters are valid
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
				header("Location: ../register.php?register=invalid");
				exit();
            }
            
            else {
				//Check if email is valid
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

					header("Location: ../register.php?register=email");
					exit();
                }
                
                else {
                    //Check if passwords match
                    if ($password != $repPassword){

                        header("Location: ../register.php?register=password-mismatch");
					    exit();
                    }

                    else {

                        if ($role === "pasazieris" || $role === "soferis") {

                            $sql = "SELECT * FROM lietotaji WHERE lietotajvards='$username'";
                            $result = $this->connect()->query($sql);
                            $resultCheck = $result->num_rows;
    
                            if ($resultCheck > 0) {
                                header("Location: ../register.php?register=usertaken");
                                exit();
                            } 
                            
                            else {
                                //Hashing the password
                                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                                // Insert the user into the database
                                $sql = "INSERT INTO lietotaji (vards, uzvards, epasts, lietotajvards, parole, telefona_numurs) VALUES ('$first', '$last', '$email', '$username', '$hashedPwd', '$phone');";
                                $result = $this->connect()->query($sql);
                                
                                $sql = "SELECT ID FROM lietotaji WHERE lietotajvards='$username'";
                                $result = $this->connect()->query($sql);
                                
                                if ($row = $result->fetch_assoc()) {
                                    
                                    $userID = $row['ID'];

                                    if ($role === "pasazieris") {

                                        $sql = "INSERT INTO lietotajiem_ir_lomas (lietotaji_ID, lomas_ID) VALUES ('$userID', 1);";
                                    }
    
                                    else {
    
                                        $sql = "INSERT INTO lietotajiem_ir_lomas (lietotaji_ID, lomas_ID) VALUES ('$userID', 2);";
                                    }

                                    $result = $this->connect()->query($sql);
    
                                    header("Location: ../register.php?register=success");
                                    exit();
                                }

                            }
                        
                        }
                    }
                        
                }
                    
            }
                
        }
            
    }

}