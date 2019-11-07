<?php
$username = null;
$password = null;
include 'config.php';

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];
      $test_login = false;
      if (array_key_exists($username, $accounts)) {
        $pass_c = $accounts[$username];
        $_SESSION["testt"] = $pass_c;
        if ($password == $pass_c) {
          $test_login = true;
        }
      }
      if (!$test_login) {
      //Establish session with moodle:
      $url1 = 'https://moodle.xamk.fi/?lang=en';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_COOKIEFILE, "shib-cookie");
      curl_setopt($ch, CURLOPT_COOKIEJAR, "shib-cookie");
      curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
      curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());

      //execute get
      $server_output = curl_exec($ch);

      //Obtain login token:
      $logintoken = get_string_between($server_output, '<input type="hidden" name="logintoken" value="', '"/><input class="btn xamk-login-button"');

      //Build POST request for authentication
      $url2 = "https://moodle.xamk.fi/login/index.php";
      $fields = array(
          'username'      => $username,
          'logintoken' => $logintoken,
          'password'         => $password,
          'login'     =>  'Kirjaudu'
      );
      $fields_string = http_build_query($fields);

      curl_setopt($ch,CURLOPT_URL, $url2);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

      //execute post
      $result = curl_exec($ch);

      curl_close($ch);
    }
      if(strpos($result, 'Invalid login, please try again') !== false && !$test_login) {
        header("Location: login.php?m=2");
      } else {
        if (!$test_login){
        $name = get_string_between($result, '<span class="userbutton"><span class="usertext">', '</span><span class="avatars">');}
        else{ $name = "Test User"; }
        if (strlen($name) < 1) {
          header("Location: login.php?m=3");
        } else {
            session_start();
            $_SESSION["authenticated"] = 'true';
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["name"] = $name;

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
              $post = [
                        'email' => $_SESSION['username'],
                        'voted' => "false",
                    ];
              $headers = [
                'Content-Type: application/json',
                'Accept: application/json'
              ];

              $ch = curl_init('http://54.166.246.251:3000/api/Voter');
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
              curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              // execute!
              $response = curl_exec($ch);
              // close the connection, release resources used
              curl_close($ch);

              $_SESSION["test"]="You have logged in for the first time, we've added you to the blockchain!";
            } else {
              $voted = var_export($json[0]->{'voted'}, true);
              $_SESSION["test"]="You are in the blockchain. Voted: ".$voted;


            }


            header('Location: index.php');
        }
      }

        // if(($username == 'user' && $password == 'password') || ($username == 'karhu' && $password == 'karjala')) {
        //     session_start();
        //     $_SESSION["authenticated"] = 'true';
        //     $_SESSION["username"] = $_POST["username"];
        //     header('Location: index.php');
        // }
        // else {
        //     header("Location: login.php?m=2");
        // }

    } else {
        header('Location: login.php');
    }
} else {
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Blockchain Voting App</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-6 col-xl-6">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Blockchain Voting App</h4>
                                    </div>
                                    <?php if(!empty($_GET["m"])) {
                                      $message = $_GET["m"];
                                      if ($message == '1') {
                                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Successfully logged out.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                      }
                                      if ($message == '2') {
                                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        Username or password is incorrect.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                      }
                                      if ($message == '3') {
                                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        Something went wrong.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';
                                      }
                                    } ?>
                                    <form class="user" method="post">
                                        <div class="form-group"><input class="form-control form-control-user" type="text" name="username" placeholder="Username"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Password" name="password"></div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label></div>
                                            </div>
                                        </div><button class="btn btn-primary btn-block text-white btn-user" type="submit">Login via XAMK</button>
                                        <hr>
                                        <p class="text-center">You can login to my Blockchain Voting application using your XAMK account.</p>
                                        <hr>
                                    </form>
                                    <div class="text-center"><a class="small" href="https://moodle.xamk.fi/mod/page/view.php?id=706848" target="_blank">Forgot Password?</a></div>
                                  <!--  <div class="text-center"><a class="small" href="https://moodle.xamk.fi">Create an Account!</a></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="assets/js/dismiss.js"></script>
</body>

</html>
