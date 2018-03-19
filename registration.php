<?php
 //Our Php code will be gose here.
require 'database.php';
$errors = [];
$username = $email = $password = $gender = $dept = $file = '';
if (isset($_POST['register'])){
  function validation($data){
      $data = htmlentities($data);
      $data = htmlspecialchars($data);
      $data = stripslashes($data);
      $data = trim($data);
      return $data;
  }
  if (empty($_POST['username'])){
      $errors['username'] = 'Username Must Be Required';
  }else{
      $username = validation($_POST['username']);
  }
  if (empty($_POST['email'])){
      $errors['email'] = 'Email Address Must Be Required';
  }else{
      $email = validation($_POST['email']);
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
          $errors['email'] = 'Email Address Must Be Valid';
      }
  }
  if (empty($_POST['password'])){
      $errors['password'] = 'Password Must Be Required';
  }else{
      $password = validation($_POST['password']);
      if (strlen($password) > 5){
          $password = password_hash($password,PASSWORD_BCRYPT);
      }
  }
  if (empty($_POST['gender'])){
      $errors['gender'] = 'Please Select Your Gender';
  }else{
      $gender = $_POST['gender'];
  }
  if (empty($_POST['dept'])){
      $errors['dept'] = 'Please Select Your Department';
  }else{
      $dept = validation($_POST['dept']);
  }
 if (empty($_FILES['file']['name'])){
      $errors['file'] = 'Please Upload Your Image';
 }else{
      $file_name = $_FILES['file']['name'];
      $file_size = $_FILES['file']['size'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $file_type = $_FILES['file']['type'];

      $data = explode('.',$file_name);
      $ext = strtolower(end($data));
      $extention = array('jpg','png','jpeg');
      if (in_array($ext,$extention) === false){
         $errors['file'] = 'File Must be JPG PNG OR JPEG  Format';
      }else{
          $new_file = uniqid('pp_',true).'.'.$ext;
      }
      if ($file_size > 2006090){
          $errors['file'] = 'File Size less than 2mb';
      }
 }

  if (empty($errors)){
     $upload = move_uploaded_file($_FILES['file']['tmp_name'],'profile/'.$new_file);
     if ($upload == true){
         if ($connection == false){
             echo mysqli_connect_errno();
             exit();
         }else{
             $sql = "INSERT INTO user (username,email,password,gender,dept,file) VALUES ('$username','$email','$password','$gender','$dept','$new_file')";
             $stmt = mysqli_query($connection,$sql);
             if ($stmt == false){
                 echo mysqli_error($connection);
                 exit();
             }else{
                 header('Location:login.php');
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
    <title>Registration Page</title>
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
              <div class="card-body">
                      <?php
                         if (isset($success)){
                             ?>
                             <div class="alert alert-success"> <?php echo $success; ?> </div>
                  <?php
                         }
                      ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                      <div class="card-header">
                          <h1 style="text-align: center; color: darkblue">User Registration Page</h1>
                      </div>
                      <div class="form-group">
                          <label for="username">UserName</label>
                          <input type="text" class="form-control" name="username" placeholder="UserName" autofocus>
                          <?php
                            if (isset($errors['username'])){
                                ?>
                                <div class="alert alert-danger"><?php echo $errors['username']; ?></div>
                          <?php
                            }
                          ?>
                      </div>
                      <div class="form-group">
                          <label for="email">E-mail</label>
                          <input type="email" class="form-control" name="email" placeholder="example@example.com" autofocus>
                          <?php
                          if (isset($errors['email'])){
                              ?>
                              <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                              <?php
                          }
                          ?>
                      </div>
                      <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" class="form-control" name="password" placeholder="******" autofocus>
                          <?php
                          if(isset($errors['password'])){
                          ?>
                          <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
                          <?php
                            }
                          ?>
                      </div>
                      <div class="form-group">
                          <label for="gender">Gender</label> <br>
                          <input type="radio" name="gender" value="Male">Male
                          <input type="radio" name="gender" value="Female">Female
                          <?php
                          if(isset($errors['gender'])){
                          ?>
                             <div class="alert alert-danger"><?php echo $errors['gender']; ?></div>
                          <?php
                            }
                          ?>
                      </div>
                      <div class="form-group">
                          <label for="dept">Department</label>
                          <select name="dept" class="form-control" >
                              <option value="">Select One</option>
                              <option value="Computer Science And Engineering">Computer Science And Engineering </option>
                              <option value="Electronic And Electrical Engineering">Electronic And Electrical Engineering</option>
                              <option value="Software Engineering">Software Engineering</option>
                              <option value="Textile Engineering">Textile Engineering</option>
                          </select>
                          <?php
                          if(isset($errors['dept'])){
                          ?>
                          <div class="alert alert-danger"><?php echo $errors['dept']; ?></div>
                          <?php
                          }
                          ?>
                      </div>
                      <div class="form-group">
                          <label for="file">Upload Image</label>
                          <input type="file" name="file" class="form-control">
                          <?php
                          if(isset($errors['file'])){
                          ?>
                          <div class="alert alert-danger"><?php echo $errors['file']; ?></div>
                          <?php
                          }
                          ?>
                      </div>
                      <div class="form-group">
                           <button type="submit" name="register" class="form-control btn btn-primary">Registration</button>
                          <a style="text-decoration: none; float: right" href="login.php">Have a account?please login</a>
                      </div>
                  </form>
              </div>
      </div>
  </div>
</body>
</html>