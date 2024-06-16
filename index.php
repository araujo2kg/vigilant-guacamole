<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location:".DIR_PATH."/login.php");
}

// Alerta se dados já foram enviados
if (isset($_GET['message'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['message']) . "');</script>";
}

// Get the data to insert into the displays

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="styles.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>Início</title>
        <style>
            label {
                color: white;
            }
        </style>

        <!-- google pie chart -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
                ]);

                var options = {
                title: 'My Daily Activities',
                backgroundColor: 'transparent'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="container">
                <div class="row" id="greeting">
                    <h1>Bem vindo <?php echo $row["nome"]; ?>!</h1>
                </div>
                <div class="row" id="form-display">
                    <div class="col-6" id="data-collect">
                        <form action="process_data.php" method="post">
                            <fieldset>
                                <legend>Quantas horas você dormiu esta noite?</legend>
                                <label><input type="radio" name="sleep-time" value="1" required> 1 hora</label>
                                <label><input type="radio" name="sleep-time" value="2" required> 2 horas</label>
                                <label><input type="radio" name="sleep-time" value="3" required> 3 horas</label>
                                <label><input type="radio" name="sleep-time" value="4" required> 4 horas</label>
                                <label><input type="radio" name="sleep-time" value="5" required> 5 horas</label>
                                <label><input type="radio" name="sleep-time" value="6" required> 6 horas</label>
                                <label><input type="radio" name="sleep-time" value="7" required> 7 horas</label>
                                <label><input type="radio" name="sleep-time" value="8" required> 8 horas</label>
                                <label><input type="radio" name="sleep-time" value="9" required> 9 horas</label>
                            </fieldset>
                            <fieldset>
                                <legend>Quão bem você dormiu esta noite?</legend>
                                <label><input type="radio" name="sleep-quality" value="1" required>Muito Mal</label>
                                <label><input type="radio" name="sleep-quality" value="2" required>Mal</label>
                                <label><input type="radio" name="sleep-quality" value="3" required>Ok</label>
                                <label><input type="radio" name="sleep-quality" value="4" required>Bem</label>
                                <label><input type="radio" name="sleep-quality" value="5" required>Muito Bem</label>
                            </fieldset>
                            <button type="submit">Enviar</button>
                        </form>
                    </div>
                    <div class="col-6" id="data-display">
                        <h3>Na maioria dos dias você se sente:</h3>
                        <div id="piechart" class="chart" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
                <div class="row" id="sleep-calc"></div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>