<?php
// Prisijungimo duomenys
$servername = 'localhost';
$dbname = 'Auto';
$username = 'Auto';
$password = 'LabaiSlaptas123';
// Prisijungiame prie duomenų bazės 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
}
$data =  htmlspecialchars($_POST['date']);
$numeris = htmlspecialchars($_POST['number']);
$kelias = (int)$_POST['distance'];
$laikas = (int)$_POST['time'];
// Suformuojame INSERT užklausą
$sql = "INSERT INTO `radars`(`date`, `number`, `distance`, `time`) VALUES(?, ?, ?, ?)"; 
//$stmt = $conn->prepare($sql);
if (!($stmt = $conn->prepare($sql))) {
    echo json_encode([
        success => false,
        error => $conn->error
    ]);
    exit;
};
// Priskiriame parametrų reikšmes
$stmt->bind_param("ssdd", $data, $numeris, $kelias, $laikas);
if (!($stmt->bind_param("ssdd", $data, $numeris, $kelias, $laikas))) {
    echo json_encode([
        success => false,
        error => $stmt->error
    ]);
    exit;
}
// Vykdome INSERT užklausą
$stmt->execute();

 echo '</table>';