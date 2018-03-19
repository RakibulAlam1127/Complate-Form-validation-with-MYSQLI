<?php
require 'database.php';
$errors = [];
$email = $password = '';
if (isset($_POST['login'])){
    if (empty($_POST['email'])){
        $errors[] = 'Email Field Must  Not Be Empty';
    }else{
        $email = $_POST['email'];
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Please Enter The Valid Email';
        }
    }
    if (empty($_POST['password'])){
        $errors[] = 'Password Field Must Not Be Empty';
    }else{
        $password = $_POST['password'];
    }
    if (empty($errors)){
      if ($connection == false){
          echo mysqli_connect_errno();
          exit();
      }else{
          $sql = "SELECT id,email,password from user WHERE email = '$email'";
          $stmt = mysqli_query($connection,$sql);
          if ($stmt == false){
              echo mysqli_error($connection);
              exit();
          }else{
              if (mysqli_num_rows($stmt) === 0){
                 $error[] = 'Email Not Found';
              }else{
                  $row = mysqli_fetch_assoc($stmt);

                  if (password_verify($password,$row['password']) === true){
                      header('Location:view.php');
                  }else{
                      $errors[] = 'Wrong Password';
                  }
              }
          }
      }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Login Page</title>
    <style>
        body{
            background: #0000ff;
        }
        .container{
            margin-top: 50px;
        }
    </style>
</head>
<body>
     <div class="container col-md-8">
           <div class="card">
                <div class="card-header">
                     <h1 style="text-align: center">Login Page</h1>
                </div>
               <div class="card-body">
                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                       <?php
                         if (isset($errors)){
                             foreach ($errors as $error){
                                 ?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
                       <?php
                             }
                         }
                       ?>
                         <div class="form-group">
                             <label for="email">E-mail</label>
                             <input type="email" name="email" class="form-control" placeholder="Example@example.com">
                         </div>
                       <div class="form-group">
                           <label for="password">Password</label>
                           <input type="password" name="password" class="form-control" placeholder="******">
                       </div>
                       <div class="form-group">
                           <button type="submit" name="login" class="form-control btn btn-primary">Log in</button>
                           <a href="registration.php" style="float: right; text-decoration: none">Have no account? Please Registration</a>
                       </div>
                   </form>
               </div>
           </div>
     </div>
</body>
</html>