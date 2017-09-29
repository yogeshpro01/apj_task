<!doctype>
<?php
	include("db.php");
?>
<html>
	<head>
		<title> Signup </title>
	</head>
	<body bgcolor="skyblue">
		<form action = "signup.php" method = "POST" enctype = "multipart/form-data">
			<table align = "center" width = "50%" border = "2" bgcolor = "orange">
				<tr align = "center">
					<td colspan="8"> <h2> Signup: </h2> </td>
				</tr>
				<tr>
					<td align="center"> Username: </td>
					<td> <input type = "text" name = "user_name"  size = "60" required/> </td>
				</tr>
				<tr>
					<td align="center"> Password: </td>
					<td> <input type = "password" name = "pass"  size = "60" required/> </td>
				</tr>
				<tr>
					<td align="center"> First name: </td>
					<td> <input type = "text" name = "f_name"  size = "60" required/> </td>
				</tr>
        <tr>
					<td align="center"> Surname: </td>
					<td> <input type = "text" name = "s_name"  size = "60" required/> </td>
				</tr>
        <tr>
					<td align="center"> Age: </td>
					<td> <input type = "text" name = "age" /> </td>
				</tr>
				<tr>
					<td align="center"> Profile picture: </td>
					<td> <input type = "file" name = "image"/> <br>NOTE:- Only PNG files are supported.</td>
				</tr>
        <tr>
					<td align="center"> Email: </td>
					<td> <input type = "text" name = "email" size = "60" required/>
					</td>
				</tr>
				<tr>
					<td align="center"> Bio: </td>
					<td><textarea name = "bio" cols = "60" rows = "10"></textarea></td>
				</tr>
				<tr align = "center">
					<td colspan="8"> <input type = "submit" name = "insert_post" value = "Sign Up" /> </td>
				</tr>
			</table>
		</form>
	</body>
</html>

<?php
  $flag=1;
	if(isset($_POST['insert_post'])){
		$user_name = $_POST['user_name'];
		$pass = $_POST['pass'];
		$f_name = $_POST['f_name'];
		$s_name = $_POST['s_name'];
		$age = $_POST['age'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
		$image = $_FILES['image']['name'];
		$image_tmp = $_FILES['image']['tmp_name'];
    $check_user = "select * from users where user_name = '$user_name' ";
    $cu_q = pg_query($db,$check_user);
    $cu_r = pg_fetch_row($cu_q);
    if($cu_r[0]>0){
      $flag=0;
      echo "<script>alert('Username not available!');</script>";
    }
    /*if($image_tmp != NULL){
      if(exif_imagetype($image_tmp) != 	IMAGETYPE_PNG){
        $flag=0;
        echo "<script>alert('Image format not supported!');</script>";
      }
    }*/
    if($image==NULL){
      $image = "default.png";
    }
    if(!ctype_alnum($user_name) && $flag){
      echo $user_name;
      $flag=0;
      echo "<script>alert('No special characters allowed in username!');</script>";
    }
    if(!ctype_alnum($pass) && $flag){
      $flag=0;
      echo "<script>alert('No special characters allowed in password!');</script>";
    }
    if(!ctype_alnum($f_name) && $flag){
      $flag=0;
      echo "<script>alert('No special characters allowed in first name!');</script>";
    }
    if(!ctype_alnum($s_name) && $flag){
      $flag=0;
      echo "<script>alert('No special characters allowed in  surname!');</script>";
    }
    if(!filter_var($age,FILTER_VALIDATE_INT) && $flag){
      $flag=0;
      echo "<script>alert('Enter valid age!');</script>";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $flag) {
      $flag=0;
      echo "<script>alert('Invalid email format!');</script>";
    }

    if($flag){
      if($image_tmp != NULL){
        $image = $user_name.".png";
        move_uploaded_file($image_tmp,"images/users/$image");
      }
		  $insert_user= "insert into users (user_name,password,admin,img_name,f_name,s_name,age,email,bio) values ('$user_name','$pass','false','$image','$f_name','$s_name','$age','$email','$bio') ";
		  $insert = pg_query($db,$insert_user);
		  if($insert){
			   echo "<script>alert('Account Created!')</script>";
			   echo "<script>window.open('index.php','_self')</script>";
		  }
	  }
 }



?>
