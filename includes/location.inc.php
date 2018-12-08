<?php

class Location extends Database {

    protected function getAllCountries() {

        $sql = "SELECT * FROM valstis;";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {

            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllCountries() {
        
        $countries = $this->getAllCountries();

        if (is_array($countries)) {
            
            foreach ($countries as $country) {
                
                echo '<option value="'.$country['ID'].'">'.$country['nosaukums'].'</option>';
            }

        }

    }

    // public function showSelectedCountry($route_ID) {

    //     $route_ID = $_GET['ID'];
    //     $route = new Routes();
    //     $row = $this->getARoute($route_ID);

    //     $country_from = $this->getNameOfCountryByID($row['no_valsts']);
    //     $city_from = $this->getNameOfCityByID($row['no_pilseta']);
    //     $country_to = $this->getNameOfCountryByID($row['uz_valsts']);
    //     $city_to = $this->getNameOfCityByID($row['uz_pilseta']); 

    //     $country_from_name = $row['no_valsts'];
    //     $city_from_name = $row['no_pilseta'];
    //     $country_to_name = $row['uz_valsts'];
    //     $city_to_name = $row['uz_pilseta']; 


    // }

    protected function getAllCitiesFromCountry($country_ID) {

        $sql = "SELECT * FROM pilsetas WHERE valstis_ID='$country_ID';";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            
            while ($row = $result->fetch_assoc()) {

                $data[] = $row;
            }

            return $data;
        }

    }

    public function showAllCitiesFromCountry($country_ID) {
        
        $cities = $this->getAllCitiesFromCountry($country_ID);
        if (is_array($cities)) {
            
            foreach ($cities as $city) {
                
                echo '<option value="'.$city['ID'].'">'.$city['nosaukums'].'</option>';
            }
        }
    }

}