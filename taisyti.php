<?php 

// Prisijungimo duomenys
$servername = 'localhost';
$dbname = 'Auto';
$username = 'Auto';
$password = 'LabaiSlaptas123';

header('Content-Type: application/json');

// Prisijungiame prie duomenų bazės 
$conn = new mysqli($servername, $username, $password, $dbname);

$data =  htmlspecialchars($_POST['date']);
$numeris = htmlspecialchars($_POST['number']);
$kelias = (int)$_POST['distance'];
$laikas = (int)$_POST['time'];

// Suformuojame UPDATE užklausą
$sql = "UPDATE `radars` SET `date` = ?, `number` = ?, `distance` = ?, `time` = ? WHERE `id` = ?"; 
$stmt = $conn->prepare($sql);

// Priskiriame parametrų reikšmes
$stmt->bind_param("ssddi", $data, $numeris, $kelias, $laikas, $id);

// Vykdome UPDATE užklausą
$stmt->execute();


echo json_encode([success => true]);