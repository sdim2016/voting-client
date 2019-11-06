<?php
require_once('authenticate.php');
$page = 'profile';

if (!empty($_POST['username']) and $_SESSION['username'] == 'odmsl002') {
  $data = [
    'email' => $_POST['username'],
    'voted' => 'false'
  ];
  $ch = curl_init('http://54.166.246.251:3000/api/Voter/'.$_POST['username']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);
}

include('inc/header.php');
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Profile</h3>
                    <div class="card shadow mb-5">
                      <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">User information</p>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <form method="post">
                              <div class="form-group">
                                <label for="username">Login</label>
                                <input class="form-control" type="text" name="username" value="<?php echo $_SESSION["username"]; ?>">
                              </div>
                              <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" value="<?php echo $_SESSION["name"]; ?>">
                              </div>
                              <?php
                                  if ($_SESSION['username'] == 'odmsl002') {
                                    echo '<div class="form-group">
                                    <input class="btn btn-outline-primary" type="submit" value="Set voted to False">
                                    </div>';
                                  }
                               ?>
                            </form>

                          </div>
                        </div>

                      </div>
                    </div>

                </div>
<?php include('inc/footer.php'); ?>
