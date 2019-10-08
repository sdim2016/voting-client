<?php
$username = null;
$password = null;

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

        $url1 = 'https://moodle.xamk.fi/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        echo $server_output;

        $logintoken = get_string_between($server_output, '<input type="hidden" name="logintoken" value="', '"/><input class="btn xamk-login-button"');
        $url2 = "https://moodle.xamk.fi/login/index.php";
        $ch = curl_init();
        //The data you want to send via POST
        $fields = array(
            'username'      => $username,
            'logintoken' => $logintoken,
            'password'         => $password,
            'login'     =>  'Вход'
        );

        //url-ify the data for the POST
        $fields_string = http_build_query($fields);

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url2);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);

        curl_close($ch);

        echo $result;



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
                                    <div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>
                                    <div class="text-center"><a class="small" href="register.html">Create an Account!</a></div>
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
</body>

</html>
