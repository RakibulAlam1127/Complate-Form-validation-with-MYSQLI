<?php
//Our Php code will be goes here.
$connection = mysqli_connect('localhost','root','','complete_form');
if ($connection == false){
    echo mysqli_connect_errno();
    exit();
}else{
    $sql = "SELECT id,username,email,gender,dept,file FROM user";
    $stmt = mysqli_query($connection,$sql);
    if ($stmt == false){
        echo mysqli_error($connection);
        exit();
    }else{
        $result = mysqli_fetch_all($stmt,1);
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
    <title>View Page</title>
    <style>
          body{
              margin-top: 50px;
              background: #ff7f50;
          }
    </style>
</head>
<body>
   <div class="container col-md-10">
          <div class="card">
               <div class="card-header">
                     <h1 class="text-muted" style="text-align: center">All Student List</h1>
               </div>
              <div class="card-body">

                    <table class="table table-striped">
                          <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Gender</th>
                                   <th>department</th>
                                   <th>Profile Photo</th>
                                   <th>View Profile</th>
                               </tr>
                          </thead>
                        <tbody>
                              <?php
                                foreach ($result as $data){
                                    ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['username']; ?></td>
                                        <td><?php echo $data['email']; ?></td>
                                        <td><?php echo $data['gender']; ?></td>
                                        <td><?php echo $data['dept']; ?></td>
                                        <td><img src="profile/<?php echo $data['file']; ?>" alt="Invalid Image" width="50"></td>
                                        <td>
                                            <a class="btn btn-sm btn-info" href="user.php?id=<?php echo $data['id']; ?>">View Profile</a>
                                        </td>
                                    </tr>
                              <?php

                                }

                              ?>
                        </tbody>
                    </table>
              </div>
          </div>
   </div>
</body>
</html>