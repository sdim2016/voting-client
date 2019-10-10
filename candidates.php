<?php
require_once 'authenticate.php';
$page = 'candidates';
include 'inc/header.php';

$num1 = 10;
$num2 = 20;
$num3 = 30;

//$sum = $num1 + $num2 + $num3;

$votesarr = array("Obama" => 10, "Trump" => 20, "Putin" => 30, "Medvedev" => 6, "Johnson" => 18);
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

  <div class="col-md-4">


<div class="card shadow mb-5">
  <div class="card-header py-3">
    <p class="text-primary m-0 font-weight-bold">Chart</p>
  </div>
  <div class="card-body text-center">
        <div class="chart-area">
            <canvas data-bs-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[<?php
              $cnds = '';
              foreach ($votesarr as $candidate => $votes) {
                $cnds = $cnds.'&quot;'.$candidate.'&quot,';
              }
              $cnds = substr($cnds, 0, -1);
              echo $cnds;
               ?>],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[<?php
                 $arr_length = count($votesarr);
                 $colors = '';
                 for ($i=0; $i < $arr_length; $i++) {
                   $colors = $colors.'&quot;'.sprintf('#%06X', mt_rand(0, 0xFFFFFF)).'&quot;,';
                 }
                 $colors = substr($colors, 0, -1);
                 echo $colors;
                 ?>],&quot;borderColor&quot;:[<?php
                 //$arr_length = count($votesarr);
                 $fff = '';
                 for ($i=0; $i < $arr_length; $i++) {
                   $fff = $fff.'&quot;#ffffff&quot;,';
                 }
                 $fff = substr($fff, 0, -1);
                 echo $fff;
                 ?>],&quot;data&quot;:[<?php
                 $vts = '';
                 foreach ($votesarr as $candidate => $votes) {
                   $vts = $vts.'&quot;'.$votes.'&quot,';
                 }
                 $vts = substr($vts, 0, -1);
                 echo $vts;
                  ?>]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:true, &quot;position&quot;:&quot;bottom&quot;},&quot;title&quot;:{}}}" width="668" height="352" class="chartjs-render-monitor" style="display: block; width: 608px; height: 320px;"></canvas>
        </div>

  </div>
</div>
</div>

  </div>
</div>

 <?php
include 'inc/footer.php';
  ?>
