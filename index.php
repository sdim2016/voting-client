<?php
require_once('authenticate.php');
$page = 'index';
include('inc/header.php');
?>

                <div class="container-fluid">
                    <h3 class="text-dark mb-1">Blockchain Voting Application</h3>
                    <h4 class="text-dark mb-1">Welcome, <?php echo $_SESSION["name"]; ?>!</h3>
                      <p>I am planning to put the main content of my application here.</p>
                </div>

<?php include('inc/footer.php'); ?>
