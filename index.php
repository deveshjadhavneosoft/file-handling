<?php
error_reporting(0);

// input fields 
$email = input_field($_POST["email"]);
$password = input_field($_POST["password"]);
$pass1=$password;

// error variables 
$emailErr = $passwordErr  = "";

// validation
if (isset($_POST["sub"])) {

    // email validation 
    if (empty($email)) {
        $emailErr = "Please Enter Email Address.";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $emailErr = "Invalid Email Address.";
    }

    // password validation 
    if (empty($password)) {
        $passwordErr = "Please Enter Password.";
    } else if (!preg_match("/^[a-zA-Z0-9]{3,16}+$/", $password)) {
        $passwordErr = "Length of password should be between 4, 16 characters.";
    }

    if ($emailErr === "" && $passwordErr  === "") {
        if (is_dir("user/".$email)) {
            $fo = fopen("user/$email/details.txt", "r");
            fgets($fo);
            if ($password === trim(fgets($fo))) {
                
                session_start();
                $_SESSION['sid']=$email;
                if(!empty($_POST['remember'])){
                    setcookie('email',$email,time()+3600*24);
                    setcookie('password',$pass1,time()+3600*24);
                }
                header("location:dashboard.php");
            } else {
                $passwordErr = "Wrong Password.";
            }
        } else {
            $emailErr = "Please check your Email id.";
        }
    }
}

if (isset($_POST["new_user"])) {
    header("Location: register.php");
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

  

    <title>Login</title>
    <script>
        function cook(){
            if("<?php echo $_COOKIE['email'];?>"!=undefined){
                if(document.getElementById("email").value=="<?php echo $_COOKIE ['email'];?>"){
                    document.getElementById("password").value="<?php echo $_COOKIE ['password'];?>"

                }
                else{
                    document.getElementById("password").value="";
                }
            }
        }
        </script>
</head>

<body>
<div class="jumbotron">
  <h1 class="display-4">Login  Panel</h1>
  
</div>
    
        <form class="form container" method="POST">
           
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" onchange="cook()">
                <small id="err" class="form-text text-danger"><?php echo $emailErr; ?></small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <small id="err" class="form-text text-danger"><?php echo $passwordErr; ?></small>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember" id="check" onclick=""> Remember me
                </label>
            </div>
            <div class="row">
                <div class="col-sm mb-2">
                    <button type="submit" class="btn btn-primary btn-block" name="sub">Login</button>
                </div>
                <div class="col-sm mb-2">
                    <button type="submit" class="btn btn-warning btn-block" name="new_user">New User</button>
                </div>
            </div>
        </form>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>