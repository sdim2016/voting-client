<?php
require_once 'authenticate.php';
$page = 'candidates';
include 'inc/header.php';

$votesarr = array("Obama" => 10, "Trump" => 20, "Putin" => 30, "Medvedev" => 6, "Johnson" => 18, "Zelensky" => 3);
$sum = 0;
foreach ($votesarr as $candidate => $votes) {
$sum += $votes;
}

 ?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">Candidates</h3>
  <div class="row">
    <div class="col-md-6">


  <div class="card shadow mb-5">
    <div class="card-header py-3">
      <p class="text-primary m-0 font-weight-bold">Candidates and their results loaded from blockchain</p>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="table-responsive">
          <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Candidate name</th>
      <th scope="col">Votes</th>
      <th scope="col">Percentage</th>
    </tr>
  </thead>
  <tbody>
    <?php
        $num = 1;
        foreach ($votesarr as $candidate => $votes) {
          echo "<tr>";
          echo '<th scope="row">'.$num.'</th>';
          echo '<td>'.$candidate.'</td>';
          echo '<td>'.$votes.'</td>';
          echo '<td><div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="'.round($votes/$sum*100).'" aria-valuemin="0" aria-valuemax="100" style="width:'.round($votes/$sum*100).'%">'.round($votes/$sum*100).'%</div>
    </div></td>';
          $num++;
        }
     ?>

  </tbody>
</table>
</div>
      </div>

    </div>
  </div>
  </div>

  <div class="col-md-5">


<div class="card shadow mb-5">
  <div class="card-header py-3">
    <p class="text-primary m-0 font-weight-bold">Chart</p>
  </div>
  <div class="card-body">
        <div class="chart-area">
            <canvas id="doughnut1" width="668" height="352" style="display: block; width: 608px; height: 320px;" class="chartjs-render-monitor"></canvas>


        </div>
<div class="custom-legend doughnut-meter-legend clearfix d-none d-lg-block"></div>
<div class="custom-legend custom-legend-2 doughnut-meter-legend clearfix d-lg-none"></div>
  </div>
</div>
</div>

  </div>
</div>


 <?php
include 'inc/footer.php';
  ?>

  <script type="text/javascript">
  var doughnutElm = document.getElementById('doughnut1');
  var doughnut1data = [<?php
  $vts = '';
  foreach ($votesarr as $candidate => $votes) {
    $vts = $vts.$votes.", ";
  }
  $vts = substr($vts, 0, -2);
  echo $vts;
   ?>];
  var cloneData = doughnut1data.slice(0);
  var doughnut1dataset = {
    labels: [
      <?php
        $cnds = '';
        foreach ($votesarr as $candidate => $votes) {
          $cnds = $cnds."'".$candidate."',";
        }
        $cnds = substr($cnds, 0, -1);
        echo $cnds;
         ?>
      ],
    datasets: [
      {
        data: doughnut1data,
        backgroundColor: [
          <?php
            $arr_length = count($votesarr);
            $colors = '';
            for ($i=0; $i < $arr_length; $i++) {
              $colors = $colors."'".sprintf('#%06X', mt_rand(0, 0xFFFFFF))."',";
            }
            $colors = substr($colors, 0, -1);
            echo $colors;
            ?>
              ],
        hoverBorderWidth: 0
                      }]
  };
  var doughnutOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false,
      labels: {
        usePointStyle: true
      }
    },
  };

  if (doughnutElm) {
    var doughnut1 = doughnutElm.getContext('2d');
    var myDoughnutChart = new Chart(doughnut1, {
      type: 'doughnut',
      data: doughnut1dataset,
      options: doughnutOptions
    });
    $('.doughnut-meter-legend').append(myDoughnutChart.generateLegend());
    $('.doughnut-meter-legend li').each(function () {
      $(this).append(': <b>' + cloneData[$(this).index()] + '</b>')
    });
    $('.doughnut-meter-legend').on('click', 'li', function () {
      myDoughnutChart.data.datasets[0].data[$(this).index()] = cloneData[$(this).index()] !== myDoughnutChart.data.datasets[0].data[$(this).index()] ? cloneData[$(this).index()] : 0;
      myDoughnutChart.update();
      $(this).toggleClass('striked');
    });
  };
  </script>
