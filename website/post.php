<?php
  include("db.php");
  session_start();
  $id = $_GET['user_id'];
  if($id != $_SESSION['id']){
    header('Location: error.php');
  }
?>

<html>
  <head>
    <title>Post</title>
  </head>
  <body  bgcolor="skyblue">
    <form action = "<?php echo "post.php?user_id=$id";?>" method = "POST" enctype = "multipart/form-data">
			<table align = "center" width = "50%" border = "2" bgcolor = "orange">
				<tr align = "center">
					<td colspan="8"> <h2> Create Post: </h2> </td>
				</tr>
				<tr>
					<td align="center"> Heading: </td>
					<td> <input type = "text" name = "head"  size = "60" required/> </td>
				</tr>
        <tr>
					<td align="center"> Content: </td>
					<td><textarea name = "con" cols = "60" rows = "10"></textarea>  <span id ="cur_len"></span><a href = "#" id = "hideshow">Hide</a></td>
				</tr>
        <tr>
					<td align="center"> Picture: </td>
					<td> <input type = "file" name = "image"/> <br>NOTE:- Only PNG files are supported.</td>
				</tr>
				<tr align = "center">
					<td colspan="8"> <input type = "submit" name = "insert_post" value = "Post" /> </td>
				</tr>
			</table>
		</form>
  </body>
  <script type="text/javascript" src = "jquery.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
	   var len = 600;
	    $('#cur_len').html(len + " characters remaining.");
	    $('textarea').keyup(function(){
		      var cur = $(this).val().length;
		      var gt_len = len-cur;
		      $('#cur_len').html(gt_len + " characters remaining.");
	    });
  });
  $('#hideshow').click(function(){
	   if($(this).text() == "Hide"){
		     $(this).text('Show');
		     $('#cur_len').hide();
	  }else{
		    $(this).text('Hide');
		      $('#cur_len').show();
	       }
   });
   </script>
</html>

<?php
$flag =1;
  if(isset($_POST['insert_post'])){
    $head = $_POST['head'];
    $con = $_POST['con'];
    $image = $_FILES['image']['name'];
		$image_tmp = $_FILES['image']['tmp_name'];
    $pnom = "select post_no from users where user_id='$id' ";
    $q = pg_query($db,$pnom);
    $row = pg_fetch_row($q);
    $row[0]++;
    /*if($image_tmp != NULL){
      if(exif_imagetype($image_tmp) != 	IMAGETYPE_PNG){
        $flag=0;
        echo "<script>alert('Image format not supported!');</script>";
      }
    }*/
    if(strlen($head)>50){
      $flag=0;
        echo "<script>alert('Heading is too long!');</script>";
    }
    if($flag){
      if($image_tmp != NULL){
        $image = $id."_".$row[0].".PNG";
        move_uploaded_file($image_tmp,"images/posts/$image");
      }
      $insert_post = "insert into posts (user_id,heading,content,img_name,post_time) values ('$id','$head','$con','$image','now()')";
      $insert = pg_query($db,$insert_post);
      $up_no = "update users set post_no = '$row[0]' where user_id = '$id' ";
      $up_in = pg_query($db,$up_no);
		  if($insert){
			   echo "<script>alert('Successfully posted!')</script>";
			   header('Location: dashboard.php?user_id='.$id);
		  }
    }
  }
?>
