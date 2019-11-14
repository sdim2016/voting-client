<?php
require_once('authenticate.php');
$page = 'index';
include('inc/header.php');
?>

                <div class="container-fluid">
                    <h3 class="text-dark mb-1">Blockchain Voting Application</h3>
                    <hr />
                    <h4 class="text-dark mb-1">Welcome, <?php echo $_SESSION["name"]; ?>!</h3>
                      <p>This application is based on blockchain.</p>
                      <p>Using blockchain for voting app provides the following benefits:</p>
                      <ul>
                        <li>resistance to the illegal data modification</li>
                        <li>immutable and distributed transaction history</li>
                        <li>smart contracts which can add complex logic to the transactions</li>
                      </ul>
                      <p><?php echo $_SESSION["test"]; ?></p>
                </div>

<?php include('inc/footer.php'); ?>
