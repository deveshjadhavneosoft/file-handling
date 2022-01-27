<?php
error_reporting(0);
include("captcha.php");


// input fields 
$name = input_field($_POST["name"]);
$email = input_field($_POST["email"]);
$username = input_field($_POST["username"]);
$password = input_field($_POST["password"]);
$age = $_POST["age"];
$gender = input_field($_POST["gender"]);
$captcha = input_field($_POST["captcha"]);
$captchaHidden = input_field($_POST["captcha_hidden"]);

$tmp = $_FILES["image"]["tmp_name"];
$iname = $_FILES["image"]["name"];

// error variables 
$nameErr = $emailErr = $usernameErr = $passwordErr = $imageErr = $ageErr = $genderErr = $captchaErr = "";

// validation
if (isset($_POST["sub"])) {

    // name validation 
    if (empty($name)) {
        $nameErr = "Name is required.";
    } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $nameErr = "Only Characters and white spaces are allowed.";
    }

    // email validation 
    if (empty($email)) {
        $emailErr = "Email Address is required.";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $emailErr = "Invalid Email Address.";
    }

    // username validation 
    if (empty($username)) {
        $usernameErr = "Username is required.";
    } else if (!preg_match("/^[a-z0-9_]+$/", $username)) {
        $usernameErr = "Only Small Characters, Numbers and \"_\" are allowed.";
    }

    // password validation 
    if (empty($password)) {
        $passwordErr = "Password is required.";
    } else if (!preg_match("/^[a-zA-Z0-9]{3,16}+$/", $password)) {
        $passwordErr = "Length of password should be between 4, 16 characters.";
    }

    // age validation 
    if (empty($age)) {
        $ageErr = "Please Enter your Age.";
    }

    // gender validation 
    if (empty($gender)) {
        $genderErr = "Please Select your Gender.";
    }
        // captcha validation 
        if (empty($captcha)) {
            $captchaErr = "Please Enter Captcha.";
        }
    

    $ext = pathinfo($iname, PATHINFO_EXTENSION);
    $fn =  $email.".". $ext;

    if ($nameErr === "" && $emailErr === "" && $usernameErr === "" && $passwordErr === ""  && $ageErr === "" && $genderErr === ""  && $captchaErr === "") {
        if ($captcha == $captchaHidden) {
        if (is_dir("user/" . $email)) {
            $emailErr = "Email id already registered.";
        } else if (is_dir("user/" . $username)) {
            $usernameErr = "Username already registered.";
        } else if ($ext == "jpg" || $ext == "png" || $ext == "jpeg") {
            mkdir("user/$email");
            $details = fopen("user/$email/" . "details.txt", "w");
            fwrite($details, $username . "\n" . $password . "\n" . $name . "\n" . $age . "\n" . $gender . "\n" . $fn);
            
            if (move_uploaded_file($tmp, "user/$email/$fn")) {
                header("location:welcome.php?uid=$email");
                exit();
            } else {
                $msg = "<div id='alert' class='alert alert-danger  text-center'>File upload Failed</div>";
            }
        } else {
            $imageErr = "Please Select image file png, jpg or jpeg";
        }
    }
    else {
        $captchaErr = "Please Enter valid Captcha.";
    }
} else {
        // 
    }
}

if (isset($_POST["backtologin"])) {
    header("Location: index.php");
    exit();
}

// trim function 
function input_field($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



    <title>Register</title>
</head>

<body>
<div class="jumbotron">
  <h1 class="display-4">Registration Panel</h1>
  
</div>
  

        <div >
            <form class="form container " method="POST" enctype="multipart/form-data">
                <div>
                   
                    <h4 class="py-3 text-success">Register</h4>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                        <small id="err" class="form-text text-danger"><?php echo $nameErr; ?></small>
                    </div>
                    <div >
                        <label for="email">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
                        <small id="err" class="form-text text-danger"><?php echo $emailErr; ?></small>
                    </div>
                    <div>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                        <small id="err" class="form-text text-danger"><?php echo $usernameErr; ?></small>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        <small id="err" class="form-text text-danger"><?php echo $passwordErr; ?></small>
                    </div>
                    <div>
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter age">
                        <small id="err" class="form-text text-danger"><?php echo $ageErr; ?></small>
                    </div>
                    <div>
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <small id="err" class="form-text text-danger"><?php echo $imageErr; ?></small>
                    </div>
                    <div>
                        <h5>Gender</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="male">
                            <label class="form-check-label" for="gender">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                            <label class="form-check-label" for="gender">
                                Female
                            </label>
                        </div>
                        <small id="err" class="form-text text-danger"><?php echo $genderErr; ?></small>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="image">Captcha: <?php echo $pattern; ?></label>
                        <input type="text" class="form-control" id="captcha" name="captcha">
                        <input type="hidden" class="form-control" id="captcha_hidden" name="captcha_hidden" value="<?php echo $capsum; ?>">
                        <small id="err" class="form-text text-danger"><?php echo $captchaErr; ?></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm mb-2">
                        <button type="submit" class="btn btn-primary btn-block" name="sub">Register</button>
                    </div>
                    <div class="col-sm mb-2">
                        <button type="submit" class="btn btn-primary btn-block" name="backtologin">Back to login </button>
                    </div>
                </div>
            </form>
            <?php echo $msg; ?>
        </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</body>

</html>