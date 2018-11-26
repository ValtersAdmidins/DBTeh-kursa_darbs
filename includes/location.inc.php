<?php

// $country_from = $route->getIDOfCountryByName($country_from_name);
// $city_from = $route->getIDOfCityByName($city_from_name);
// $country_to = $route->getIDOfCountryByName($country_to_name);
// $city_to = $route->getIDOfCityByName($city_to_name);

// $country_from_ID = $country_from['ID'];
// $city_from_ID = $city_from['ID'];
// $country_to_ID = $country_to['ID'];
// $city_to_ID = $city_to['ID'];

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