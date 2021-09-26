<?php
include_once '../../../loader.php';

use App\Services\CityService;
use App\Services\ProvinceValidator;
use  App\Utilities\Response;

$request_method = $_SERVER['REQUEST_METHOD'];
$request_body = json_decode(file_get_contents('php://input'), true);

$city_service = new CityService();
switch ($request_method) {
    case 'GET':
        $province_validator = new ProvinceValidator();
        $province_id = $_GET['province_id'] ?? null;
        # do validate : $province_id
        if (!$province_validator->is_valid_province($province_id))
            Response::respondAndDie(["Error: invalid province ..."], Response::HTTP_NOT_FOUND);
        $request_data = [
            'province_id' => $province_id
        ];
        $response = $city_service->getCities($request_data);
        Response::respondAndDie($response, Response::HTTP_OK);
    case 'POST':
        
        if (!isValidCity($request_body)) {
            Response::respondAndDie(["Invalid City Data"], Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $city_service->createCity($request_body);
        Response::respondAndDie($response, Response::HTTP_CREATED);
    case 'PUT':
        [$city_id,$city_name] = [$request_body['city_id'],$request_body['name']];
        if (!is_numeric($city_id) || empty($city_name) || !is_string($city_name)) 
        Response::respondAndDie(["Invalid City Data"], Response::HTTP_NOT_ACCEPTABLE);
        $response = $city_service->updateCityName($city_id,$city_name);
        if (!$response)
        Response::respondAndDie(["Error: failed to change the city name"], Response::HTTP_NO_CONTENT);
         Response::respondAndDie($response, Response::HTTP_OK);
    case 'DELETE':
        $city_id = $_GET['city_id'] ?? null;
        if (!is_numeric ($city_id )|| is_null($city_id))
        Response::respondAndDie(["Invalid City Id"], Response::HTTP_NOT_ACCEPTABLE);
        $response = $city_service->deleteCity($city_id);
        Response::respondAndDie($response, Response::HTTP_OK);
    default:
        Response::respondAndDie(['Invalid Request Method'], Response::HTTP_METHOD_NOT_ALLOWED);
}
