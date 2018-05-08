<?php 

// Prisijungimo duomenys
$servername = 'localhost';
$dbname = 'Auto';
$username = 'Auto';
$password = 'LabaiSlaptas123';

// Prisijungiame prie duomenų bazės 
$conn = new mysqli($servername, $username, $password, $dbname);

$id = 41;
$data = '2017-07-18 15:17:25';
$numeris = '000001';
$kelias = 5000;
$laikas = 99;

// Suformuojame UPDATE užklausą
$sql = "UPDATE `radars` SET `date` = ?, `number` = ?, `distance` = ?, `time` = ? WHERE `id` = ?"; 
$stmt = $conn->prepare($sql);

// Priskiriame parametrų reikšmes
$stmt->bind_param("ssddi", $data, $numeris, $kelias, $laikas, $id);

// Vykdome UPDATE užklausą
$stmt->execute();


echo '</table>';