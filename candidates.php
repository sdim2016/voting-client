<?php
require_once 'authenticate.php';
$page = 'candidates';
include 'inc/header.php';

$num1 = 10;
$num2 = 20;
$num3 = 30;

$sum = $num1 + $num2 + $num3;

$votes = array("Obama" => 10, "Trump" => 20, "Putin" => 30);


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
    <tr>
      <th scope="row">1</th>
      <td>Obama</td>
      <td><?php echo $num1; ?></td>
      <td><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($num1/$sum*100); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($num1/$sum*100); ?>%"><?php echo round($num1/$sum*100); ?>%</div>
</div></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Trump</td>
      <td><?php echo $num2; ?></td>
      <td><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($num2/$sum*100); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($num2/$sum*100); ?>%"><?php echo round($num2/$sum*100); ?>%</div>
</div></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Putin</td>
      <td><?php echo $num3; ?></td>
      <td> <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($num3/$sum*100); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($num3/$sum*100); ?>%"><?php echo round($num3/$sum*100); ?>%</div>
      </div></td>
    </tr>
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
            <canvas data-bs-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Obama&quot;,&quot;Trump&quot;,&quot;Putin&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;<?php echo $num1; ?>&quot;,&quot;<?php echo $num2; ?>&quot;,&quot;<?php echo $num3; ?>&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{}}}" width="668" height="352" class="chartjs-render-monitor" style="display: block; width: 608px; height: 320px;"></canvas>
        </div>
        <div class="text-center small mt-4">
            <span class="mr-2"><i class="fas fa-circle text-primary"></i> Putin</span>
            <span class="mr-2"><i class="fas fa-circle text-success"></i> Trump</span>
            <span class="mr-2"><i class="fas fa-circle text-info"></i> Obama</span>
        </div>

  </div>
</div>
</div>

  </div>
</div>

 <?php
include 'inc/footer.php';
  ?>
