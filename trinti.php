<?php 

// Prisijungimo duomenys
$servername = 'localhost';
$dbname = 'Auto';
$username = 'Auto';
$password = 'LabaiSlaptas123';

// Prisijungiame prie duomenų bazės 
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_REQUEST['id'];

// Suformuojame DELETE užklausą
$sql = "DELETE FROM `radars` WHERE `id` = ?"; 
$stmt = $conn->prepare($sql);

// Priskiriame parametrų reikšmes
$stmt->bind_param("i", $id);

// Vykdome DELETE užklausą
$stmt->execute();


echo '</table>';

