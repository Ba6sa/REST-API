<?php
//  required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
// include database and object files

include_once '../Config/database.php';
include_once '../Objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);
// read products will be here
//  query products
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    $product_arr=array();
    $product_arr["records"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item = array(
            "id" => $id,    
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        array_push($product_arr["records"], $product_item);
    }
    //  Status code
    http_response_code(200);
    // display in json format
    echo json_encode($product_arr);

} else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No product found.")
    );
}
?>
