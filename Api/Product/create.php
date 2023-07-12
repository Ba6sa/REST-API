<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../Config/database.php';
include_once '../Objects/product.php';


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

    // checking if data is not empty
if (
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)

    // product property values
){
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    // Create the product for user
    if ($product->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Product was created"));
    }
    // Serevice unavailable
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create producct"));
    }
} 
    // 400 Bad request
    else {
        http_response_code(400); 
        echo json_encode(array("message" => "Unable to create product. Data is incomplete"));
    }
