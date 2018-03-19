<?php
$id = $_GET['id'];
$id = (int) $id;
if ($id === 0){
    header('Location:login.php');
}
$connection = mysqli_connect('localhost','root','','complete_form');
 if ($connection == false){
     echo mysqli_connect_errno();
     exit();
 }else{
     $sql = "SELECT id,username,email,gender,dept,file,create_at FROM user WHERE id='$id'";
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
    <title>View Profile</title>
    <style>
        body{
            margin-top: 50px;
            background: #25638b;
        }
    </style>
</head>
<body>
    <div class="container col-md-8">
          <div class="card">
                <div class="card-header">
                      <h1 style="text-align: center; "><?php echo $result['username']; ?>'s Profile </h1>
                </div>
              <div class="card-body">
                  <div  style="width: 300px; margin: auto" class="right">
                      <img src="profile/<?php echo $result['file']; ?>" alt="Invalid Image" width="400px; ">
                      <a  class="label label-info" href="change_profile_photo.php?id=<?php echo $result['id']; ?>">Change Profile Picture</a>
                  </div>
                  <hr>
                  <div class="left">
                      <h4>Name : <?php echo $result['username']; ?></h4>
                      <h5>E-mail: <?php echo $result['email']; ?></h5>
                       <h5>Id Number : <?php echo $result['id']; ?></h5>
                      <h5>Gender :<?php echo $result['gender']; ?></h5>
                      <h5>Department :<?php echo $result['dept']; ?></h5>
                      <p>Create :<?php echo $result['create_at']; ?></p>
                  </div>
                  <div class="update-page pull left" style="float: left">
                      <a class="btn btn-info" href="edit.php?id=<?php echo $result['id']; ?>">Upgrade Profile</a>

                  </div>
                  <div class="delete-page pull-right" style="float: right">
                      <a class="btn btn-danger" href="delete.php?id=<?php echo $result['id']; ?>" onclick="confirm('Are You Sure ? ')">Delete</a>
                  </div>


              </div>
          </div>
    </div>
</body>
</html>
