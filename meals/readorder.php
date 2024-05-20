<?php

include('Orders.class.php');
//headeras med inställningar för rest webbtjänsten

header('Access-Control-Allow-Origin: *');
header('Content-Type_ application/json');
header('Access-Controll-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Reguested-With');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$method = $_SERVER['REQUEST_METHOD'];

//skapa instans av klassen 
$order = new Orders();

switch($method) {

        case 'GET': 

   $orderList =  $order-> getOrderList();
echo $orderList;
     



break;

case 'POST': 
 
    //konvertera inmatad data till json format
     $inputData = json_decode(file_get_contents("php://input"), true);
   
     if(empty($inputData)){
   
       $createOrder = $order->createOrder($_POST);
   
     }else {
       $createOrder = $order->createOrder($inputData);
     }
   
   echo $createOrder;
     
   break;  

    case 'DELETE': 
  
        $deleteOrder = $order-> deleteOrder($_GET);
        echo $deleteOrder;
      
 break; 

          

 }





?> 