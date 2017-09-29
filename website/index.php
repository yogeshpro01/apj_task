<?php
  include("db.php");
  session_start();
?>

<html>
  <head>
    <title>Poster</title>
  </head>
  <body bgcolor="skyblue">
    <form name = "main" method = "post" action = "index.php">
      <table align = "center" width = "30%" border = "2" bgcolor = "orange">
				<tr align = "center">
					<td colspan="8"> <h2> Login: </h2> </td>
				</tr>
        <tr>
					<td align="center"> Username: </td>
					<td> <input type = "text" name = "user"  size = "60" required/> </td>
				</tr>
				<tr>
					<td align="center"> Password: </td>
					<td> <input type = "password" name = "pass"  size = "60" required/> </td>
				</tr>
        <tr align = "center">
					<td colspan="8"> <input type = "submit" name = "but" value = "Login"></td>
				</tr>
        <tr>
          <td align = "center" colspan="8">Don't have an account? Sign up <a href="signup.php"> here </a></td>
        </tr>
    </form>
  </body>
</html>

<?php
	if(isset($_POST['but'])){
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$check = "select * from users where user_name='$username' ";
		$run_query = pg_query($db,$check);
		$row = pg_fetch_row($run_query);
		if($row[0] > 0){
			$ch_pass = $row[2];
      echo $ch_pass;
			$id=$row[0];
			if($password==$ch_pass){
        $_SESSION['id'] = $id;
				header('Location: dashboard.php?user_id='.$id);
			}else{
				echo "
					<script>alert('Wrong Password!');</script>
					";
			}
		}else{
			echo "
				<script>alert('Wrong Username!');</script>
			";

		}
	}
?>
