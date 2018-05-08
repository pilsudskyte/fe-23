<?php 

header("Content-type:application/json");

// Prisijungimo duomenys
$servername = 'localhost';
$dbname = 'Auto';
$username = 'Auto';
$password = 'LabaiSlaptas123';

// Prisijungiame prie duomenų bazės 
$conn = new mysqli($servername, $username, $password, $dbname);

// Suformuojame SELECT užklausą
$sql = 'SELECT * FROM `radars` ORDER BY `number`, `date` DESC';

// Vykdome suformuotą užklausą duomenų bazėje
$result = $conn->query($sql);

// Tikriname ar rezultate yra bent viena eilutė
$data = [];
if ($result->num_rows > 0) {
    // einame cikle per visas rezultato eilutes ir jas išvedame
    while($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
}
// uždarome prisijungimą prie DB
$conn->close();

echo '</table>';