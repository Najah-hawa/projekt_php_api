<?php

//$db = new mysqli("localhost","root","","Meals");
$db = new mysqli('studentmysql.miun.se', 'naha2204', '6337PJNrZr', 'naha2204');
if($db->connect_errno > 0){
    die('Fel vid anslutning [' . $db->connect_error . ']');
} 


/* SQL-fråga för att skapa tabell */
$sql = "DROP TABLE IF EXISTS Meals, Orders;";

/* SQL-fråga för att skapa tabell */
$sql .= "DROP TABLE IF EXISTS Meals;
    CREATE TABLE Meals(
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        meal_name  VARCHAR(64) NOT NULL,
        meal_ingredient  text,
        price  int NOT NULL
);";
$sql.=  "CREATE TABLE Orders(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    namn VARCHAR(64) NOT NULL,
    persons int NOT NULL,
    email text NOT NULL,
    ankomst DATE,
    klocka int NOT NULL,
    tid timestamp NOT NULL
);";

/* SQL-fråga för att lägga in data */
$sql .= "INSERT INTO Meals (meal_name, meal_ingredient, price) VALUES
('Chicken pasta','Olivolja, lök, vitlöksklyftor, tomater, kyckling,
cheddar, mozzarella persilja', '180');";
$sql .= "INSERT INTO Meals (meal_name, meal_ingredient, price) VALUES
('Rostad kyckling','Hel kyckling, citron, timjan, vitlök, olivolja
Smör', '220');";
$sql .= "INSERT INTO Meals (meal_name, meal_ingredient, price) VALUES
('Fajita kycklingris','Kycklingbröst, paprika, lök, majs, lime, zested, oi, bönor, koriander, ris, salsa.', '170');";
$sql .= "INSERT INTO Orders (namn, persons, email, ankomst, klocka) VALUES
('Najah','5', 'najah.hawa@gmail.com' ,'2024/05/17', '20');";
$sql .= "INSERT INTO Orders (namn, persons, email, ankomst, klocka) VALUES
('Hoda','5', 'hoda@gmail.com', '2024/05/20', '16');";
$sql .= "INSERT INTO Orders (namn, persons,email, ankomst, klocka) VALUES
('Massa','10', 'massa@gmail.com', '2024/05/18', '10');";

echo "<pre>$sql</pre>"; // Skriv ut SQL-frågan till skärm

/* Skicka SQL-frågan till DB */
if($db->multi_query($sql)) {
    echo "Tabell installerad.";
} else {
    echo "Fel vid installation av Tabell.";
}

?>

