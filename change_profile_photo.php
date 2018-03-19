<?php
//Our Php code will goes here.
$id = $_GET['id'] ?? 0;
$id = ((int) $id);
$connection = mysqli_connect('localhost','root','','complete_form');
if ($connection == false){
    echo mysqli_connect_errno();
    exit();
}else{
     if (isset($_POST['image'])){
        if (empty($_FILES['file']['name'])){
            $errors[] = 'Please Upload Your Image';
        }else{
            $file = $_FILES['file']['name'];
            $data = explode('.',$file);
            $ext = end($data);
            $new_file = uniqid('pp_',true).'.'.$ext;
        }

        if (empty($errors)){
            $uploard =  move_uploaded_file($_FILES['file']['tmp_name'],'profile/'.$new_file);
            if ($uploard == true){
                  $sql = "UPDATE user SET file = '$new_file' WHERE id='$id'";
                  $stmt = mysqli_query($connection,$sql);
                  if ($stmt == false){
                      echo mysqli_error($connection);
                      exit();
                  }else{
                      header('Location:view.php');
                  }
            }else{
                $errors[] = 'File Not Uploarded';
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
    <title>change Profile Picture</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body{
            margin-top: 100px;
            background: #dc143c;
        }
    </style>
</head>
<body>
      <div class="container col-md-8">

          <div class="card">
                <div class="card-header">
                     <h1 style="text-align: center"> Change Your Profile Photo</h1>
                </div>
              <div class="card-body">
                  <?php
                  if (isset($errors)){
                      foreach ($errors as $error){
                          ?>
                          <div class="alert alert-danger"><?php echo $error; ?></div>
                          <?php
                      }
                  }
                  ?>
                  <form action="?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
                       <div class="form-group">
                           <label for="file">Change Profile Photo</label>
                           <input type="file" name="file" class="form-control">
                       </div>
                        <div class="form-group">
                            <input type="submit" onclick="confirm('Are You Sure ?')" class="form-control btn btn-primary" name="image" value="Upload">
                        </div>
                  </form>
              </div>
          </div>
      </div>
</body>
</html>