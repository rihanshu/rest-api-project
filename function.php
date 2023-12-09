<?php

require_once('db.php');

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,        
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();  
}

function getCustomerList(){
    global $conn;
    $query = 'SELECT * FROM customers';
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',     
                'data' => $res   
            ];
            header("HTTP/1.0 200 OK");
            return(json_encode($data));  
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',        
            ];
            header("HTTP/1.0 404 No Customer Found");
            return(json_encode($data));  
        }
    }
    else{
        $data=[
            'status' => 500,
            'message' => 'Internal Server Error',        
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return(json_encode($data));
    }
}

function getCustomer($custId){
    global $conn;
    $id=$custId['id'];
    if($id==null){
        return error422('Enter Customer ID!!');
    }
    $customerId=mysqli_real_escape_string($conn,$id);

    $query = "SELECT * FROM customers
    WHERE id='$customerId' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) == 1){
            $res = mysqli_fetch_assoc($query_run);
            $data = [
                'status' => 200,
                'message' => 'Customer Fetched Successfully',     
                'data' => $res   
            ];
            header("HTTP/1.0 200 OK");
            return(json_encode($data));  
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',        
            ];
            header("HTTP/1.0 404 No Customer Found");
            return(json_encode($data));  
        }
    }
    else{
        $data=[
            'status' => 500,
            'message' => 'Internal Server Error',        
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return(json_encode($data));
    }
}

function storeCustomer($customerInput){

    global $conn;
    $name=mysqli_real_escape_string($conn, $customerInput['name']);
    $email=mysqli_real_escape_string($conn, $customerInput['email']);
    $phone=mysqli_real_escape_string($conn, $customerInput['phone']);

    if(empty(trim($name))){
        return error422('Enter your name!!');
    }
    elseif(empty(trim($email))){
        return error422('Enter your email!!');
    }
    elseif(empty(trim($phone))){
        return error422('Enter your phone no.!!');
    }
    else{
        $query = "INSERT INTO customers(name,email,phone) VALUES('$name','$email','$phone')";
        $result = mysqli_query($conn,$query);
    }
    if($result){
        $data=[
            'status' => 201,
            'message' => 'Customer Created Successfully',        
        ];
        header("HTTP/1.0 201 Created");
        return(json_encode($data));
    }
    else{
        $data=[
            'status' => 500,
            'message' => 'Internal Server Error',        
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return(json_encode($data));
    }

}

function updateCustomer($updatedData,$id){
    
    global $conn;

    if(!isset($id['id'])){
        return error422('Customer Id not found in URL!!');
    }
    elseif($id['id']==null){
        return error422('Enter the Customer Id!!');
    }

    $id=mysqli_real_escape_string($conn, $id['id']);


    $name=mysqli_real_escape_string($conn, $updatedData['name']);
    $email=mysqli_real_escape_string($conn, $updatedData['email']);
    $phone=mysqli_real_escape_string($conn, $updatedData['phone']);



    if(empty(trim($name))){
        return error422('Enter your name!!');
    }
    elseif(empty(trim($email))){
        return error422('Enter your email!!');
    }
    elseif(empty(trim($phone))){
        return error422('Enter your phone no.!!');
    }
    else
    {
        $query = "UPDATE customers SET name='$name',email='$email', phone='$phone'
        WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn,$query);
    }
    if($result){
        $data=[
            'status' => 200,
            'message' => 'Customer Updated Successfully',        
        ];
        header("HTTP/1.0 200 Success");
        return(json_encode($data));
    }
    else{
        $data=[
            'status' => 500,
            'message' => 'Internal Server Error',        
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return(json_encode($data));
    }
}

function deleteCustomer($custParam){

    global $conn;
    if(!isset($custParam['id'])){
        
        return error422('Customer Id not found in URL!!');
    }
    elseif($custParam['id']==null){
        return error422('Enter the Customer Id!!');
    }
    
        $id=mysqli_real_escape_string($conn, $custParam['id']);
        $query = "DELETE FROM customers WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn,$query);

        if($result){
            $data=[
                'status' => 200,
                'message' => 'Customer Deleted Successfully',        
            ];
            header("HTTP/1.0 200 OK");
            return(json_encode($data));
        }
        else{
            $data=[
                'status' => 404,
                'message' => 'Customer Not Found',        
            ];
            header("HTTP/1.0 404 Not Found");
            return(json_encode($data));
        }


}

?>