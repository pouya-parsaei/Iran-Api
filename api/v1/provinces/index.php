<?php
include_once '../../../loader.php';

use App\Services\ProvinceService;
use App\Utilities\Response;
use App\Services\ProvinceValidator;
use App\Utilities\CacheUtility;

$province_service = new ProvinceService;
$province_validator = new provinceValidator;

$request_body = json_decode(file_get_contents('php://input'), true);
$request_method = $_SERVER['REQUEST_METHOD'];
$province_id = $_GET['province_id'] ?? null;
$province_name = $request_body['name'] ?? null;

switch ($request_method) {
    case 'GET':
        CacheUtility::start();
        $province_id = $_GET['province_id'] ?? null;
        $whitelist = ['province_id', 'page', 'page_size', 'orderby'];
        $query_parameters = array_keys($_GET);
        foreach ($query_parameters as $query_parameter) {
            if (!in_array($query_parameter, $whitelist))
                Response::respondAndDie("Error: invalid query parameter", Response::HTTP_NOT_ACCEPTABLE);
        }
        if (isset($province_id)) {
            if (!$province_validator->is_valid_province_in_cities($province_id))
                Response::respondAndDie("Error: invalid province id", Response::HTTP_NOT_ACCEPTABLE);
        }
        $requested_province = [
            'province_id' => $province_id,
            'page' => $_GET['page'] ?? null,
            'page_size' => $_GET['page_size'] ?? null,
            'orderby' => $_GET['orderby'] ?? null,
        ];
        $response = $province_service->getProvinces($requested_province);
        echo Response::respond($response, Response::HTTP_OK);
        CacheUtility::end();
        die();
    case 'POST':

        if (!(isset($province_name) || is_string($province_name))) {
            Response::respondAndDie("Error: invalid provinde data", Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $province_service->createProvince($request_body);
        Response::respondAndDie($response, Response::HTTP_OK);
    case 'PUT':
        $province_id = $request_body['id'];
        if (!(isset($province_name) || is_string($province_name) || is_numeric($province_id) || isset($province_id))) {
            Response::respondAndDie("Error: invalid provinde data", Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $province_service->updateProvinceName($province_id, $province_name);
        Response::respondAndDie($response, Response::HTTP_OK);
    case 'DELETE':
        if (isset($province_id)) {
            if (!$province_validator->is_valid_province_in_provinces($province_id))
                Response::respondAndDie("Error: invalid province id", Response::HTTP_NOT_ACCEPTABLE);
        };
        $response = $province_service->deleteProvince($province_id);
        Response::respondAndDie($province_service, Response::HTTP_OK);
    default:
        Response::respondAndDie("Invalid Request Method", Response::HTTP_METHOD_NOT_ALLOWED);
}
