<?php
$errors = [];
$id = $_GET['id'] ??  0;
$id = ((int) $id);
if ($id === 0){
    header('Location:login.php');
}
 $connection = mysqli_connect('localhost','root','','complete_form');
if ($connection == false){
    echo mysqli_connect_errno();
    exit();
}else{
    $username = $email = $gender = $dept = '';
    if (isset($_POST['update'])){


      if (empty($_POST['username'])){
          $errors['username'] = 'Username Must be Required';
      }else{
          $username = $_POST['username'];
      }
      if (empty($_POST['email'])){
            $errors['email'] = 'Email Address Must be Required';
      }else{
            $email = $_POST['email'];

      }
      if (empty($_POST['gender'])){
            $errors['gender'] = 'Please Select Your Gender';
      }else{
            $gender = $_POST['gender'];
      }
      if (empty($_POST['dept'])){
            $errors['dept'] = 'Please Select Your Department';
      }else{
            $dept = $_POST['dept'];
      }
      if (empty($errors)){
//         var_dump($username,$email,$gender,$dept);
//         die();
            $sql_query = "UPDATE user SET username ='$username', email= '$email' , gender= '$gender', dept= '$dept' WHERE id='$id'";

            $stmt_query = mysqli_query($connection,$sql_query);
            if ($stmt_query == false){
                echo mysqli_error($connection);
                exit();
            }else{
                header('Location:view.php');
            }

      }

    }



    $sql = "SELECT username,email,gender,dept FROM user WHERE id='$id'";
     $stmt = mysqli_query($connection,$sql);
      if ($stmt == false){
          echo mysqli_error($connection);
          exit();
      }else{
          $result = mysqli_fetch_assoc($stmt);
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
    <title>Update Profile</title>
    <style>
        body{
            margin-top: 50px;
            background: #8b008b;
        }
    </style>
</head>
<body>
     <div class="container col-md-8">
            <div class="card">
                  <div class="card-header">
                        <h1 class="text-muted" style="text-align: center">Upgrade Profile</h1>
                  </div>
                <div class="card-body">
                    <form action="?id=<?php echo $_GET['id']; ?>" method="post">
                         <div class="form-group">
                             <label for="username">Username</label>
                             <input type="text" name="username" class="form-control" value="<?php echo $result['username']; ?>">
                             <?php
                               if (isset($errors['username'])){
                                   ?>
                                   <div class="alert alert-danger"><?php echo $errors['username']; ?></div>
                             <?php
                               }
                             ?>
                         </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $result['email']; ?>">
                            <?php
                            if (isset($errors['email'])){
                                ?>
                                <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Select Your Gender</label> <br>
                            <input type="radio" name="gender" value="Male">Male
                            <input type="radio" name="gender" value="Female">Female
                            <?php
                            if (isset($errors['gender'])){
                                ?>
                                <div class="alert alert-danger"><?php echo $errors['gender']; ?></div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <select name="dept" class="form-control">
                                <option value="">Select One</option>
                                <option value="Computer Science And Engineering">Computer Science And Engineering </option>
                                <option value="Electronic And Electrical Engineering">Electronic And Electrical Engineering</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Textile Engineering">Textile Engineering</option>
                            </select>
                            <?php
                            if (isset($errors['dept'])){
                                ?>
                                <div class="alert alert-danger"><?php echo $errors['dept']; ?></div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update" class="form-control btn btn-primary" value="Upgrade">
                        </div>
                    </form>
                </div>
            </div>
     </div>
</body>
</html>
