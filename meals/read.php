<?php

include('Meals.class.php');
//headeras med inställningar för rest webbtjänsten

header('Access-Control-Allow-Origin: *');
header('Content-Type_ application/json');
header('Access-Controll-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Reguested-With');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$method = $_SERVER['REQUEST_METHOD'];

//skapa instans av klassen 
$meal = new Meals();

switch($method) {

        case 'GET': 

   $mealList =  $meal-> getMealList();
echo $mealList;
     



break;

case 'POST': 
 
    //konvertera inmatad data till json format
     $inputData = json_decode(file_get_contents("php://input"), true);
   
     if(empty($inputData)){
   
       $createMeal = $meal->createMeal($_POST);
   
     }else {
       $createMeal = $meal->createMeal($inputData);
     }
   
   echo $createMeal;
   
     
   break;  
   case 'PUT': 
      //konvertera inmatad data till json format
       $inputData = json_decode(file_get_contents("php://input"), true);
       $updateMeal = $meal->updateMeal($inputData, $_GET);   
       
     echo $updateMeal;
    
    break; 

    case 'DELETE': 
  
        $deleteMeal = $meal-> deleteMeal($_GET);
        echo $deleteMeal;
      
 break; 

          

 }





?> 