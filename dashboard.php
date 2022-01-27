<?php 
 session_start();
 $sid=$_SESSION['sid'];
 if(empty($sid)){
   header("location:index.php");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
      />
</head>
<body>

<main>
        <header>
            <?php include("nav.php");?>
        </header>
        <section class="row container">
          <aside class="col-sm-4"> <?php include("sidebar.php");?></aside>
          <aside class="col-sm-8">
             <?php 
              switch(@$_GET['con']){
                case 'changepass' : include("changepass.php");
                  break;
                case 'category' : include("category.php");
                break;
                case 'orders' : include("orders.php");
                break;
                case 'products' : include("products.php");
                break;
                case 'feedback' : include("feedback.php");
                break;
              }
             ?>
          </aside>
        </section>
    </main>

  


</body>
</html>