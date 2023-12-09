<?php
error_reporting(0);
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Method:POST");
header("Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

include('../function.php');

$requestMethod=$_SERVER["REQUEST_METHOD"];

if($requestMethod=="POST"){
    
    $inputData = json_Decode(file_get_contents("php://input"),true);

    if(empty($inputData)){

            $storeCustomer = storeCustomer($_POST);
    }
    else{
        $storeCustomer = storeCustomer($inputData);
    }
    echo $storeCustomer; 
}
else{
    $data = [
        "status" => 405,
        'message' => $requestMethod.' method not allowed',
    ];
    header("HTTP/1.0 405 Method not Allowed");
    echo json_encode($data);
}
?>