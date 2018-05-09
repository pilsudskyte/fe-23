<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            margin-left: 5%;
        }
        .modal1 {
            visibility: hidden;
            position: fixed;
            left: 0; right: 0; top: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal1 .content {
            background-color: white;
            padding: 10px;
            border: 4px solid white;
            border-radius: 4px;
            box-shadow: 1px 1px 4px black;
        }
    
    </style>
</head>

<body>
        <?php

        $servername = 'localhost';
        $dbname = 'Auto';
        $username = 'Auto';
        $password = 'LabaiSlaptas123';
        
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die('Nepavyko prisjungti: ' . $conn->connect_error);
        }
        
        $row = [];
        
        if (isset($_GET['edit'])){
            $sql = "SELECT * FROM radars WHERE id =".$_GET['edit'];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
        }
        
        if (isset($_POST['save'])) {
            if ($_POST['id'] > 0) {
                $sql = "UPDATE radars SET `number` = ?, `date` = ?, `distance` = ?, `time` = ? WHERE id = ?"; 
                $stmts = $conn->prepare($sql);
                $stmts->bind_param("ssddi", $_POST['number'], $_POST['date'], $_POST['distance'], $_POST['time'], $_POST['id']);
                $stmts->execute(); 
            } else {
                $insert = "INSERT INTO radars(`number`, `date`, `distance`, `time`) VALUES(?, ?, ?, ?)"; 
                $stmt = $conn->prepare($insert);
                $stmt->bind_param("ssdd", $_POST['number'], $_POST['date'], $_POST['distance'], $_POST['time']);
                $stmt->execute();
            }
        }

        ?> 
        <form action="autos_duomenys.php" method="POST">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Naujas
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Lentele:</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>
                                <input placeholder="Data"  name="date" type="text" value="<?= $row['date'] ?>"required><br>
                                </label>
        
                                <label>
                                <input placeholder="Numeris" name="number" type="text" value="<?= $row['number'] ?>"required><br>
                                </label>
        
                                <label>
                                <input placeholder="Atstumas" name="distance" type="text" value="<?= $row['distance'] ?>"required><br>
                                </label>
        
                                <label>
                                <input placeholder="Laikas" name="time" type="text" value="<?= $row['time'] ?>"required><br>
                                </label>
                                <label>
                                <input name="id" type="hidden" value="<?= $row['id'] ?>"required><br>
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
                                <input type="submit"  class="btn btn-secondary" name="save" value="Issaugoti"><br>
                            </div>
                        </div>
                    </div>
                </div>
</form>  

    <div id="container">
        <div id="error"></div>
        <h3>Lentele:</h3>
        <table border=1>
            <thead>
                <tr>
                    <td>id</td>
                    <td>Data</td>
                    <td>Numeris</td>
                    <td>Atstumas</td>
                    <td>Greitis km/h</td>
                    <td>Veiksmas1</td>
                    <td>Veiksmas2</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="modal1" id="confirm" onclick="closeConfirm()">
        <div class="content">
            <p>Ar tikrai norite istrinti?</p>
            <div>
                <button>Ne</button>
                <button id="confirm-ok">Taip</button>
            </div>
        </div>
    </div>

    <script>
        $(function () {

            gautiLentele();

        });

        function gautiLentele() {
            $.get('lentele.php', function (resp) {
                if (resp.success) {
                    rodytilentele(resp.data);
                } else {
                    $('#error').text('kazkokia klaida');
                }
            }).fail(function () {
                $('#error').text('kazkokia rimta klaida');
            });
        }

        function rodytilentele(data) {
            var txt = '';
            data.forEach(x => {
                txt += '<tr>' +
                    '<td>' + x.id + '</td>' +
                    '<td>' + x.date + '</td>' +
                    '<td>' + x.number + '</td>' +
                    '<td>' + x.distance + '</td>' +
                    '<td>' + (x.distance/x.time*3.6).toFixed(0)  + '</td>' +
                    '<td>' +
                    // '<a href="trinti.php?id=' + x.id + '">Trinti</a>' + 
                    '<button onclick="trinti(' + x.id + ')">Trinti</button>' +
                    '<td>' +
                    '<button onclick="taisyti(' + x.id + ')">Taisyti</button>' +
                    '</td>' +
                    '</tr>';
            });
            document.querySelector('tbody').innerHTML = txt;
        }
 
        function trinti(autoId) {
            document.getElementById('confirm').style.visibility = 'visible';
            document.getElementById('container').style.filter = 'blur(2px)';


            document.getElementById('confirm-ok').onclick = function() {
                // $('#error').text('Trinamas id: ' + autoId);
 
                $.get('trinti.php', { id: autoId }, function (resp) {
                    if (resp.success) {
                        gautiLentele();

                    } else {
                        $('#error').text('kazkokia klaida trinant');
                    }
                }).fail(function () {
                    $('#error').text('kazkokia rimta klaida trinant');
                });            
            }  
        }
        
        function closeConfirm() {
            document.getElementById('confirm').style.visibility = 'hidden';
            document.getElementById('container').style.filter = 'blur(0)';
        }
    </script>
</body>

</html>