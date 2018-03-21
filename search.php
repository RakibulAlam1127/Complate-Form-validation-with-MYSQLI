<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>search Value</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	 <div class="container">
	 	 <div class="card">
	 	 	  <div class="card-header">
	 	 	  	  <h1 style="text-align: center;">Search Result</h1>
	 	 	  </div>
	 	 	  <div class="card-body">
	 	 	  	  <?php 

                    if (isset($_POST['search'])) {
                    	$search = $_POST['search_value'];
                    	$connection = mysqli_connect('localhost','root','','complete_form');
                    	if ($connection == false) {
                    		echo mysqli_connect_errno();
                    		exit();
                    	}else{
                    		$sql = "SELECT * FROM user WHERE id LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'";
                    		$stmt = mysqli_query($connection,$sql);
                    		if ($stmt == false) {
                    			echo mysqli_errno($connection);
                    			exit();
                    		}else{
                    			$result = mysqli_num_rows($stmt);
                    			if ($result > 0) {
                    				
                    				while ($row = mysqli_fetch_assoc($stmt)) {
                    					?>
                    					<table class="table table-striped">
                    						<thead>
                    							   <th>Id</th>
				                                   <th>Username</th>
				                                   <th>Email</th>
				                                   <th>Gender</th>
				                                   <th>department</th>
				                                   <th>Profile Photo</th>
				                                   <th>View Profile</th>
                    						</thead>
                    						<tbody>
                    							   <tr>
				                                        <td><?php echo $row['id']; ?></td>
				                                        <td><?php echo $row['username']; ?></td>
				                                        <td><?php echo $row['email']; ?></td>
				                                        <td><?php echo $row['gender']; ?></td>
				                                        <td><?php echo $row['dept']; ?></td>
				                                         <td><img src="profile/<?php echo $row['file']; ?>" alt="Invalid Image" width="50"></td>
				                                        <td>
				                                            <a class="btn btn-sm btn-info" href="user.php?id=<?php echo $row['id']; ?>">View Profile</a>
				                                        </td>
                                                     </tr>

                    						</tbody>
                    					</table>

                    				<?php
                    				}

                    			}else{
                    				header('Location:notFound.php');
                    			}
                    		}
                    	}
                    }


	 	 	  	   ?>
	 	 	  </div>
	 	 </div>
	 </div>  
</body>
</html>