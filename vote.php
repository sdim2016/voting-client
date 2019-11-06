<?php
require_once 'authenticate.php';
$page = 'vote';
include 'inc/header.php';

$candidatesarr = array("Obama", "Trump", "Putin", "Medvedev", "Johnson", "Zelensky");

//Obtaining our voter data from the blockchain
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://54.166.246.251:3000/api/Voter?filter={"where":{"email":"'.$_SESSION["username"].'"}}',
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
 ?>

 <div class="container-fluid">
     <h3 class="text-dark mb-1">Vote</h3>
     <hr />
     <div class="row">
       <div class="col-md-8">
         <div class="card shadow mb-5">
           <div class="card-header py-3">
             <p class="text-primary m-0 font-weight-bold">Current voting</p>
           </div>
           <div class="card-body">
             <div class="row">
               <?php if ($voted_bool) {
                 echo "<p>You have already voted. <a href=\"candidates.php\">See current results.</a></p>";
               } ?>
               <table class="table">
       <thead>
         <tr>
           <th scope="col">#</th>
           <th scope="col">Candidate name</th>
           <th scope="col">Vote</th>
         </tr>
       </thead>
       <tbody>
         <?php
             $num = 1;
             foreach ($candidatesarr as $candidate) {
               echo "<tr>";
               echo '<th scope="row">'.$num.'</th>';
               echo '<td>'.$candidate.'</td>';
               if ($voted_bool) {
                 echo '<td class="text-center"><button type="button" class="btn btn-primary btn-sm" disabled>Vote for '.$candidate.'!</button></td>';
               } else {
               echo '<td class="text-center"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#voteModal'.$num.'">Vote for '.$candidate.'!</button></td>';

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
        Are you sure that you want to vote for '.$candidate.'?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger px-5" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success px-5">Yes</button>
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

 <?php
include 'inc/footer.php';
  ?>
