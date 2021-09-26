<?php

namespace App\Services;

class ProvinceService
{
  public function getProvinces($data)
  {
    $result = getProvinces($data);
    return $result;
  }

  public function createProvince($data)
  {
    $resutl = addProvince($data);
    return $resutl;
  }

public function updateProvinceName($province_id, $name){
  $result = changeProvinceName($province_id, $name);
  return $result;
}
public function deleteProvince($province_id){
  $result = deleteProvince($province_id);
  return $result;
}

}
