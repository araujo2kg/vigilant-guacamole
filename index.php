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
$current_date = date("Y-m-d");
$monthly_date = date('Y-m-d', strtotime($current_date . ' - 1 month'));
$weekly_date = date("Y-m-d", strtotime($current_date . ' - 1 week'));

$monthly_sleep_quality_query = "SELECT sleep_quality, COUNT(*) AS count FROM sleep_data
                        WHERE user_id = $id AND sleep_date BETWEEN '$monthly_date' AND '$current_date'
                        GROUP BY sleep_quality";

$weekly_sleep_quality_query = "SELECT sleep_quality, COUNT(*) AS count FROM sleep_data
                        WHERE user_id = $id AND sleep_date BETWEEN '$weekly_date' AND '$current_date'
                        GROUP BY sleep_quality";


$monthly_quality_counts = [
    '1' => 0,
    '2' => 0,
    '3' => 0,
    '4' => 0,
    '5' => 0
];

$weekly_quality_counts = [
    '1' => 0,
    '2' => 0,
    '3' => 0,
    '4' => 0,
    '5' => 0
];

$monthly_results = mysqli_query($conn, $monthly_sleep_quality_query);
if ($monthly_results){
    while ($row_monthly = mysqli_fetch_assoc($monthly_results)) {
            $sleep_quality = $row_monthly['sleep_quality'];
            $count = $row_monthly['count'];
            // Add the counts to the array
            $monthly_quality_counts[$sleep_quality] = $count;
    }
}

$weekly_results = mysqli_query($conn, $weekly_sleep_quality_query);
if ($weekly_results){
    while ($row_weekly = mysqli_fetch_assoc($weekly_results)) {
            $sleep_quality = $row_weekly['sleep_quality'];
            $count = $row_weekly['count'];
            // Add the counts to the array
            $weekly_quality_counts[$sleep_quality] = $count;
    }
}

$most_frequent_monthly = array_search(max($monthly_quality_counts), $monthly_quality_counts);
$most_frequent_weekly = array_search(max($weekly_quality_counts), $weekly_quality_counts);

$monthly_chart = [
    'Muito Mal' => $monthly_quality_counts['1'],
    'Mal' => $monthly_quality_counts['2'],
    'Ok' => $monthly_quality_counts['3'],
    'Bem' => $monthly_quality_counts['4'],
    'Ótimo' => $monthly_quality_counts['5']
];

$weekly_chart = [
    'Muito Mal' => $weekly_quality_counts['1'],
    'Mal' => $weekly_quality_counts['2'],
    'Ok' => $weekly_quality_counts['3'],
    'Bem' => $weekly_quality_counts['4'],
    'Ótimo' => $weekly_quality_counts['5']
];

$monthly_json = json_encode($monthly_chart);
$weekly_json = json_encode($weekly_chart);

$qualities = [
    1 => 'Muito mal',
    2 => 'Mal',
    3 => 'Ok',
    4 => 'Bem',
    5 => 'Ótimo',
];

$monthly_average_query = "SELECT avg(sleep_quality) AS avg FROM sleep_data WHERE user_id = $id AND sleep_date BETWEEN '$monthly_date' AND '$current_date'";
$monthly_average = mysqli_query($conn, $monthly_average_query);
$monthly_average = mysqli_fetch_assoc($monthly_average);
$monthly_average = intval(round($monthly_average['avg']));
$monthly_average = $qualities[$monthly_average];

$weekly_average_query = "SELECT avg(sleep_quality) AS avg FROM sleep_data WHERE user_id = $id AND sleep_date BETWEEN '$weekly_date' AND '$current_date'";
$weekly_average = mysqli_query($conn, $weekly_average_query);
$weekly_average = mysqli_fetch_assoc($weekly_average);
$weekly_average = intval(round($weekly_average['avg']));
$weekly_average = $qualities[$weekly_average];

echo "<script> console.log('$current_date'); </script>";
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
            google.charts.setOnLoadCallback(drawWeeklyChart);

            function drawChart() {
                var sleep_data = <?php echo $monthly_json;?>;
                var sleep_array = [['Quality', 'Count']];
                Object.keys(sleep_data).forEach(function(key){
                    sleep_array.push([key, Number(sleep_data[key])]);
                });
                var data = google.visualization.arrayToDataTable(sleep_array);
                var options = {
                    title: 'Qualidade do sono mensalmente',
                    backgroundColor: 'transparent',
                    sliceVisibilityThreshold: 0,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }

            function drawWeeklyChart() {
                var sleep_data = <?php echo $weekly_json;?>;
                var sleep_array = [['Quality', 'Count']];
                Object.keys(sleep_data).forEach(function(key){
                    sleep_array.push([key, Number(sleep_data[key])]);
                });
                var data = google.visualization.arrayToDataTable(sleep_array);
                var options = {
                    title: 'Qualidade do sono semanalmente',
                    backgroundColor: 'transparent',
                    sliceVisibilityThreshold: 0,
                };
                var chart = new google.visualization.PieChart(document.getElementById('weekly-piechart'));
                chart.draw(data, options);
            }
        </script>

    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-md-4 data-collect">
                    <h1>Bem vindo <?php echo $row["nome"]; ?>!</h1>
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
                                <label><input type="radio" name="sleep-quality" value="5" required>Ótimo</label>
                            </fieldset>
                            <button type="submit">Enviar</button>
                        </form>
                    </div>
                    <div class="col-md-4 data-display">
                        <div>Seu sono mais frequente no mês é:</div>
                        <div id="most-frequent-month"><?php echo array_search(max($monthly_chart), $monthly_chart); ?> </div>
                        <div>Mensalmente seu sono é em média:</div>
                            <?php echo $monthly_average; ?>
                        <div id="piechart" class="chart" style="width: 600px; height: 500px;"></div>
                    </div>
                    <div class="col-md-4 data-display">
                        <div>Seu sono mais frequente na semana é:</div>
                        <div id="most-frequent-week"><?php echo array_search(max($weekly_chart), $weekly_chart); ?> </div>
                        <div>Semanalmente seu sono é em média:</div>
                            <?php echo $weekly_average; ?>
                        <div id="weekly-piechart" class="chart" style="width: 600px; height: 500px;"></div>
                    </div>
                </div>
                <div class="row" id="sleep-calc"></div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>