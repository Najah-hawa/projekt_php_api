<?php
//include('../inc/dbcon.php');
class Orders {
    private $conn;
    public $namn;
    public $persons;
    public $email; 
    public $ankomst;
    public $klocka;
   
   
    //construktor
    function __construct(){
    //connect to stabasen 
      $this -> conn =new mysqli('studentmysql.miun.se', 'naha2204', '6337PJNrZr', 'naha2204');
      //$this -> conn = new mysqli("localhost","root","","Meals");
    if($this -> conn->connect_errno > 0){
        die('Fel vid anslutning försök igen ');
    }
    }


    //läsa alla Orders i databasen
    function getOrderList() {
    
    $query = "SELECT * FROM  Orders ;";
    $query_run = mysqli_query ($this->conn, $query);
    
    
    if($query_run){
    //check if the query exicts
    if(mysqli_num_rows($query_run) > 0){
    $Respons = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    //$response = array($Respons);
    http_response_code(200);   //pk
    return json_encode($Respons);
    
    }else {
        $response = array('message' =>  'Det finns inga order att visa',);
        http_response_code(404);   //Internal Server Error
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
    



//skapa en funktion för att lägg till order
function createOrder($orderInput){

    $namn = mysqli_real_escape_string($this->conn,$orderInput['namn']);
    $persons = mysqli_real_escape_string($this->conn,$orderInput['persons']);
    $email = mysqli_real_escape_string($this->conn,$orderInput['email']);
    $ankomst = mysqli_real_escape_string($this->conn,$orderInput['ankomst']);
    $klocka = mysqli_real_escape_string($this->conn,$orderInput['namn']);

    if(empty(trim($namn))){

        $response = array('message' =>  'Du måste ange ditt namn ',);
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
       

    }elseif(empty(trim($persons))){
    
        $response = array('message' =>  'Du måste ange antal personer',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
        

    }elseif(empty(trim($email))){
    
        $response = array('message' =>  'Du måste ange email',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
        

    }elseif(empty(trim($ankomst))){

        $response = array('message' =>  'Du måste ange ankomsttid',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
        
    } elseif(empty(trim($klocka))){

        $response = array('message' =>  'ange rätt tid',);
         http_response_code(422);   //Internal Server Error
         echo json_encode($response);
         exit();
    }else{
$query = "INSERT INTO Orders (namn,persons,email, ankomst,klocka) VALUES ('$namn','$persons', '$email', '$ankomst', '$klocka')";

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



//radera en order med id 

function deleteOrder($orderParams) {
  
    if(!isset($orderParams ['id'])){

        $response = array( 'message' => 'order id hittades inte i URL');
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
      }elseif($orderParams['id'] ==null){
      // om ingen id har skciats i url
        $response = array( 'message' => 'skrev order id som du vill uppdatera');
        http_response_code(422);   //Internal Server Error
        echo json_encode($response);
        exit();
      } 
    
        $orderId = mysqli_real_escape_string($this->conn, $orderParams['id']);

        $query = "DELETE FROM Orders WHERE id='$orderId' LIMIT 1";

        $result = mysqli_query($this->conn, $query);

        if($result){
            $response = array( 'message' => 'order raderades');
            http_response_code(201);   //ok
            echo json_encode($response);
        }else {
           
            $response = array( 'message' => 'Not Found');
            http_response_code(404); 
            echo json_encode($response);
        }
    }




}