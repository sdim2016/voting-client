<?php
require_once('authenticate.php');
$page = 'profile';
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
                            <form>
                              <div class="form-group">
                                <label for="username">Login</label>
                                <input class="form-control" type="text" name="username" value="<?php echo $_SESSION["username"]; ?>">
                              </div>
                              <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" value="<?php echo $_SESSION["name"]; ?>">
                              </div>

                            </form>
                          </div>
                        </div>

                      </div>
                    </div>

                </div>
<?php include('inc/footer.php'); ?>
