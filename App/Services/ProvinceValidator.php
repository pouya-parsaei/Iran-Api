<?php
namespace App\Services;

class ProvinceValidator
{
    public function is_valid_province_in_cities($data){
        $reslt =  provinceExistsInCities($data);
        return $reslt;
   }
   public function is_valid_province_in_provinces($data){
    $reslt =  provinceExistsInProvinces($data);
    return $reslt;
   }
}

