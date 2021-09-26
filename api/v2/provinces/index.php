<?php
include_once '../../../loader.php';

use App\Services\ProvinceService;
use  App\Utilities\Response;;

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        $response = getProvinces();
        Response::respondAndDie($response,Response::HTTP_OK);
    case 'POST':
        Response::respondAndDie("POST Method",Response::HTTP_OK);
    case 'PUT':
        Response::respondAndDie("PUT Method",Response::HTTP_OK);
    case 'DELETE':
        Response::respondAndDie("DELETE Method",Response::HTTP_OK);
    default:
    Response::respondAndDie("Invalid Request Method",Response::HTTP_METHOD_NOT_ALLOWED);
}
