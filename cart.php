
<?php session_start(); 

if (isset($_POST['logout']) && !empty($_SESSION['username'])) {
	
	session_destroy();
	header("Location: index.php");
}



?>
<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="bootstrap-override.css">
		<link rel="stylesheet" type="text/css" href="css/index1.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


	<nav class="navbar navbar-static-top navbar-inverse">
	  <div class="container-fluid">
	  
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-control="navbar">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar" ></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar" style="background-color:"></span>
	      </button>
	      <h4><a class="navbar-brand" align="center" style="color:white; font-size: 150%;" href="index.php">Shopping</a></h4>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      	<!-- <ul class="nav navbar-nav navbar-center">
	      			<li><a class="btn btn-lg navactive" href="index.php"></a></li>
	      	</ul> -->
	      	<ul class="nav navbar-nav navbar-right">
		        
		        
				
						<?php
						if (isset($_SESSION['username'])!="") 
						{
						?>
							<li><a class="btn btn-lg" type="button" href="cart.php"><i class="fa fa-shopping-cart fa-1x"></i>&nbsp;Cart
		        			<span class="badge">
		        				<?php 
		        					$username = $_SESSION['username'];
									$con=mysqli_connect("localhost","root","","shopping") or die(mysqli_error());
		        					$query = "SELECT * FROM cart WHERE username='$username'";
									$result = mysqli_query($con, $query);
									$count = mysqli_num_rows($result);
									echo $count;
								?>
		        			</span></a></li>
							<li><a class="btn btn-lg navactive" style="color:white;">Hello <?php echo $_SESSION['username']; ?></a></li>
							<li><form action="index.php" method="POST">
							<input type="submit" name="logout" class="btn btn-lg navactive" value="logout">
							</form></li>

						<?php
						}
						else
						{
						?>	<li><a class="btn btn-lg navactive" href="signup.php">Signup</a></li>
							<li><a class="btn btn-lg navactive" href="login.php">Login</a></li>
						<?php } ?>
			</ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	





</nav>
<div class="container">
	<h2 style="text-align:center;">Your Cart</h2>
	<br><br>
	

<?php

	$username = $_SESSION['username'];
	$con=mysqli_connect("localhost","root","","shopping") or die(mysqli_error());

	if (isset($_GET['rproductname'])) {
		$rpdtname = $_GET['rproductname'];
		$query = "DELETE FROM `cart` WHERE `username` = '$username' AND `productname` = '$rpdtname'";
		mysqli_query($con, $query);
	}

	
	//data from cart
	$query = "SELECT * FROM cart WHERE username='$username'";
	$result = mysqli_query($con, $query);
	$count = mysqli_num_rows($result);
	
	if ($count>0) 
	{
		echo "<table class=\"table table-striped\">
				<thead>
					<tr>
						<th>S.no</th>
						<th>Product Name</th>
						<th>Short Description</th>
						<th>Availability</th>
						<th>Price</th>
						<th>Remove</th>
					</tr>
				</thead>";
		$i=1;
			while($row=mysqli_fetch_array($result))
			{	
				//data from product table
				$pdtname=$row['productname'];
				$sql = "SELECT shortdescription, availability, price FROM product WHERE productname='$pdtname'";
				$res = mysqli_query($con, $sql);
				$rcount = mysqli_num_rows($res);
				$data=mysqli_fetch_array($res);
				if ($rcount>0) 
				{				
					echo "<tbody>
							<tr>
								<td>".$i."</td>
								<td>".$row['productname']."</td>
								<td>".$data['shortdescription']."</td>
								<td>".$data['availability']."</td>
								<td>".$data['price']."</td>
								<td><a href=\"cart.php?rproductname=".$row['productname']."\">Remove</a></td>
							</tr>
						</tbody>";
						$i = $i + 1;
				}
				else
				{
					echo "<tbody>
						<tr>
							<td>".$i."</td>
							<td>".$row['productname']."</td>
							<td>not available</td>
							<td>not available</td>
							<td>not available</td>
						</tr>
					</tbody>";
					$i = $i + 1;
				}
			}
		}
?>
		
	</table>
</div>