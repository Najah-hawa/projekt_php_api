<?php
//include('../inc/dbcon.php');
class Meals {
    private $conn;
    public $meal_name;
    public $meal_ingredient;
    public $price;
   
   
    //construktor
    function __construct(){
    //connect to stabasen 
     $this -> conn =new mysqli('studentmysql.miun.se', 'naha2204', '6337PJNrZr', 'naha2204');
     
     //$this -> conn = new mysqli("localhost","root","","Meals");
    if($this -> conn->connect_errno > 0){
        die('Fel vid anslutning försök igen ');
    }
    }


    //läsa alla meals i databasen
    function getMealList() {
    
    $query = "SELECT * FROM  Meals ;";
    $query_run = mysqli_query ($this->conn, $query);
    
    
    if($query_run){
    //check if the query exicts
    if(mysqli_num_rows($query_run) > 0){
    $Respons = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    //$response = array($Respons);
    http_response_code(200);   //pk
    return json_encode($Respons);
    
    }else {
        $response = array('message' =>  'Det finns inga meal att visa',);
        http_response_code(404);   //Not Found
        return json_encode($response);

    }
    } 
    else
    {
        $response = array('message' =>  'Internal Server Error',);
        http_response_code(500);   //Internal Server Error
        echo json_encode($response);
    }  
    }
    



//skapa en funktion för att lägg till meal
function createMeal($mealInput){

    $meal_name = mysqli_real_escape_string($this->conn,$mealInput['meal_name']);
    $meal_ingredient = mysqli_real_escape_string($this->conn,$mealInput['meal_ingredient']);
    $price = mysqli_real_escape_string($this->conn,$mealInput['price']);
 

    if(empty(trim($meal_name))){

        $response = array('message' =>  'Du måste ange meal_name',);
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
       

    }elseif(empty(trim($meal_ingredient))){
    
        $response = array('message' =>  'Du måste ange meal_ingredient',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
        

    }elseif(empty(trim($price))){

        $response = array('message' =>  'Du måste ange price',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
        
    } else {
$query = "INSERT INTO Meals (meal_name,meal_ingredient,price ) VALUES ('$meal_name','$meal_ingredient','$price')";

$result = mysqli_query($this->conn, $query);

if($result){
    $response = array("messsage" => 'created' );
    http_response_code(201);   //internal server error
    echo json_encode($response);

}else{

    $response = array("messsage" => 'internal server error' );
    http_response_code(500);   //internal server error
    echo json_encode($response);
}
 }
}



//radera en meal med id 

function deleteMeal($mealParams) {
  
    if(!isset($mealParams ['id'])){

        $response = array( 'message' => 'meal id hittades inte i URL');
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
      }elseif($mealParams['id'] ==null){
      // om ingen id har skciats i url
        $response = array( 'message' => 'skrev meal id som du vill uppdatera');
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
      } 
    
        $mealId = mysqli_real_escape_string($this->conn, $mealParams['id']);

        $query = "DELETE FROM Meals WHERE id='$mealId' LIMIT 1";

        $result = mysqli_query($this->conn, $query);

        if($result){
            $response = array( 'message' => 'meal raderades');
            http_response_code(201);   //ok
            echo json_encode($response);
        }else {
           
            $response = array( 'message' => 'Not Found');
            http_response_code(404); 
            echo json_encode($response);
        }
    }




//uppdatera en meal

function updateMeal($mealInput,$mealParams){
// kontrollera om id skicades 
  if(!isset($mealParams['id'])){

    $response = array( 'message' => 'meal id hittades inte i URL');
    http_response_code(422); //Internal Server Error
    echo json_encode($response);
    exit();  


  }elseif($mealParams['id'] ==null){
  // om ingen id har skciats i url
    $response = array( 'message' => 'skrev meal id som du vill uppdatera');
    http_response_code(422); //Internal Server Error
    echo json_encode($response);
    exit();  
  } 

    $mealId = mysqli_real_escape_string($this->conn,$mealParams['id']);
    $meal_name = mysqli_real_escape_string($this->conn,$mealInput['meal_name']);
    $meal_ingredient = mysqli_real_escape_string($this->conn,$mealInput['meal_ingredient']);
    $price = mysqli_real_escape_string($this->conn,$mealInput['price']);

    if(empty(trim($meal_name))){

    $response = array( 'message' => 'Du måste ange meal_name');
    http_response_code(422); //Internal Server Error
    echo json_encode($response);
    exit();  

         
    }elseif(empty(trim($meal_ingredient))){
      
         $response = array( 'message' => 'Du måste ange meal_ingredient');
         http_response_code(422); //Internal Server Error
         echo json_encode($response);
         exit();  

    }elseif(empty(trim($price))){

         $response = array( 'message' => 'Du måste ange price');
         http_response_code(422); //Internal Server Error
         echo json_encode($response);
         exit(); 

    } else {
$query = "UPDATE Meals SET meal_name = '$meal_name', meal_ingredient = '$meal_ingredient', price ='$price' WHERE id = '$mealId' LIMIT 1";

$result = mysqli_query($this->conn, $query);

if($result){
    
    $response = array( 'message' => 'meal uppdaterad');
         http_response_code(201); //meal uppdaterades 
         echo json_encode($response);

}else{
    $response = array( 'message' => 'internal server error');
         http_response_code(500); //meal uppdaterades 
         echo json_encode($response);
    
}
 }
}
}