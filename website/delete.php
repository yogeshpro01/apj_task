<?php
  include("db.php");
  session_start();
  $id = $_GET['user_id'];
  $post = $_GET['post_id'];
  if($id != $_SESSION['id']){
    header('Location: error.php');
  }
  $q1 = "select * from posts where post_id = '$post' " ;
  $qx1 = pg_query($db,$q1);
  $row1 = pg_fetch_row($qx1);
?>

<html>
  <head>
    <title>Delete</title>
  </head>
  <body bgcolor="skyblue">
    <form name = "main" method = "post" action = "<?php $str = 'delete.php?post_id='.$post.'&user_id='.$id;echo $str;?>">
      <table align = "center" width = "30%" border = "2" bgcolor = "orange">
				<tr align = "center">
					<td colspan="8"> <h2> Delete: </h2> </td>
				</tr>
    </form>
  </body>
</html>

<?php
if($row1[4] != NULL){
  echo "
    <tr>
    <td align = 'center' colspan='8'>
    <b>$row1[2]</b><br>
    <img src = 'images/posts/$row1[4]' align = 'center' width = '300px' height = '300px'>
    <p>$row1[3]</p>
    </td></tr>
  ";
}else{
  echo "
    <tr colspan='8'>
    <td align = 'center' colspan='8'>
    <b>$row[2]</b><br>
    <p>$row[3]</p>
    </td></tr>
  ";
  }
  echo "
  <tr align = 'center'>
    <td colspan='8'> <input type = 'submit' name = 'but' value = 'Delete'></td>
  </tr>
  </table>
  ";
  if(isset($_POST['but'])){
    $qs = "delete from posts where post_id = '$post' ";
    $query = pg_query($db,$qs);
    if($query){
       echo "<script>alert('Post Deleted!')</script>";
       header('Location: dashboard.php?user_id='.$id);
    }
  }
?>
