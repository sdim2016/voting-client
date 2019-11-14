<?php
require_once 'authenticate.php';
$page = 'vote';
$votefor = '';

//$candidatesarr = array("Obama", "Trump", "Putin", "Medvedev", "Johnson", "Zelensky");

//Obtaining our voter data from the blockchain
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://54.166.246.251:3000/api/Voter?filter={"where":{"username":"'.$_SESSION["username"].'"}}',
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
//Decoded result:
$json = json_decode($resp);
if (!$json) {
  $_SESSION["test"]="You are not in the blockchain!";
} else {
  $voted = var_export($json[0]->{'voted'}, true);
  $_SESSION["test"]="You are in the blockchain. Voted: ".$voted;
  if ($voted == 'true') {
    $voted_bool = true;
  } else {
    $voted_bool = false;
  }
}

//Obtaining our candidates data from the blockchain
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://54.166.246.251:3000/api/Candidate',
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
//Decoded result:
$candidatesarr = json_decode($resp);

if (!empty($_GET['votefor'])) {
  $votefor = $_GET['votefor'];
  $valid = false;
  foreach ($candidatesarr as $candidate) {
    if ($candidate -> {'name'} == $votefor) {
      $valid = true;
    }
  }
  if ($valid and !$voted_bool) {
      $post = [
                'voter' => $_SESSION['username'],
                'candidate' => $votefor,
            ];
      $headers = [
        'Content-Type: application/json',
        'Accept: application/json'
      ];

      $ch = curl_init('http://54.166.246.251:3000/api/MakeVote');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      // execute!
      $response = curl_exec($ch);
      // close the connection, release resources used
      curl_close($ch);

      header('Location: vote.php');

  }
}


include 'inc/header.php';
 ?>

 <div class="container-fluid">
     <h3 class="text-dark mb-1">Vote</h3>
     <hr />
     <div class="row">
       <div class="col-md-8">
         <?php
         if (!empty($votefor) and !$valid) {
             echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
             No such candidate!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
             </div>';
         }

         //echo var_export($post);
         //echo "<br/>";
         //echo var_export($response);
          ?>
         <div class="card shadow mb-5">
           <div class="card-header py-3">
             <p class="text-primary m-0 font-weight-bold">Current voting</p>
           </div>
           <div class="card-body">
             <div class="row">

               <?php if ($voted_bool) {
                 echo "<p>You have already voted. <a href=\"candidates.php\">See current results.</a></p>";
               }
                ?>
                <div class="table-responsive">
               <table class="table">
       <thead>
         <tr>
           <th scope="col">#</th>
           <th scope="col">Candidate name</th>
           <th scope="col" style="text-align: center">Vote</th>
         </tr>
       </thead>
       <tbody>
         <?php
             $num = 1;
             foreach ($candidatesarr as $candidate) {
               echo "<tr>";
               echo '<th scope="row">'.$num.'</th>';
               echo '<td>'.$candidate -> {'name'}.'</td>';
               if ($voted_bool) {
                 echo '<td class="text-center"><button type="button" class="btn btn-primary btn-sm" disabled>Vote for '.$candidate -> {'name'}.'!</button></td>';
               } else {
               echo '<td class="text-center"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#voteModal'.$num.'">Vote for '.$candidate -> {'name'}.'!</button></td>';

               echo '<div class="modal fade" id="voteModal'.$num.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure that you want to vote for '.$candidate -> {'name'}.'?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger px-5" data-dismiss="modal">No</button>
        <a href="vote.php?votefor='.$candidate -> {'name'}.'"><button type="button" class="btn btn-success px-5">Yes</button></a>
      </div>
    </div>
  </div>
</div>';
             }
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
 </div>
</div>

 <?php
include 'inc/footer.php';
  ?>
