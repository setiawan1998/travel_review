<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Travel Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js'></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Data Tempat Wisata</h1>
        <br>
            <select class="form-control" id="option">
                <option value="all"> -pilih tempat wisata- </option>
                <?php foreach($data as $row){ ?>
                    <option><?php echo $row->nama_wisata ?></option>
                <?php } ?>
            </select>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Wisata</th>
                            <th>Rating(Positif, Negatif)</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php foreach($data as $row){ ?>
                            <tr>
                                <td><?php echo $row->nama_wisata ?></td>
                                <td align="right"><b><?php echo $row->data ?></b></td>
                            <tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <canvas id="myChart" width="100" height="100"></canvas>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Positif", "Negatif"],
            datasets: [{
                data: <?php echo "[".$rating->data."]" ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
            }]
        }
    });
    $('#option').change(function(){
        myChart.destroy();
        var nama_wisata = this.value;
        if(nama_wisata == "all"){
            $.ajax({
                url: 'http://localhost:8080/travel_review/index.php/Dashboard/all',
                success: function(data){
                    $('#table').html(data);
                    $.ajax({
                        url: 'http://localhost:8080/travel_review/index.php/Dashboard/allChart',
                        dataType: 'JSON',
                        success: function(data){
                            var dataChartSplit = data.data.split(',');
                            myChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ["Positif", "Negatif"],
                                    datasets: [{
                                        data: dataChartSplit.map(Number),
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                        ],
                                    }]
                                }
                            });
                        }
                    })
                }
            })
        }else{
            $.ajax({
                type: 'POST',
                url: 'http://localhost:8080/travel_review/index.php/Dashboard/getData/',
                data: { nama_wisata },
                success: function(data){
                    $('#table').html(data);
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost:8080/travel_review/index.php/Dashboard/getDataChart/',
                        data: { nama_wisata },
                        dataType: 'JSON',
                        success: function(data){
                            var dataChartSplit = data.data.split(',');
                            myChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ["Positif", "Negatif"],
                                    datasets: [{
                                        data: dataChartSplit.map(Number),
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                        ],
                                    }]
                                }
                            });
                        }
                    });
                }
            });
        }
    })
</script>