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
    <title>Dashboard</title>
  </head>
  <body bgcolor="skyblue">
    <table align = "center" width = "80%" border = "2" bgcolor = "orange">
      <tr align = "center">
        <td colspan="8"> <h2> Dashboard: </h2> </td>
      </tr>
      <tr>
        <td align="center"><a href = "<?php echo "post.php?user_id=$id";?>">Add a Post</a> </td>
        <td align="center"><a href = "<?php echo "profile.php?user_id=$id";?>">View Profile</a></td>
        <td align="center"><a href = "<?php echo "donate.php?user_id=$id";?>">Donate</a></td>
        <td align="center"><a href = "<?php echo "logout.php";?>">Logout</a></td>
      </tr>
      <tr>
        <td colspan="8"> <b>Posts:</b> </td>
      </tr>
  </body>
</html>

<?php
  $query = "select * from posts";
  $gq = pg_query($db,$query);
  while($row = pg_fetch_array($gq)){
    $qx = "select user_name from users where user_id='$row[1]' ";
    $qxl = pg_query($db,$qx);
    $gn = pg_fetch_row($qxl);
    $qx2 = "select admin from users where user_id='$id' ";
    $qxl2 = pg_query($db,$qx2);
    $gn2 = pg_fetch_row($qxl2);
    $link = "profile.php?user_id=".$row[1];
    date_default_timezone_set('Asia/Kolkata');
    if($row[4] != NULL){
      echo "
        <tr>
        <td align = 'center' colspan='8'>
        <b>$row[2]</b><br>
        <img src = 'images/posts/$row[4]' align = 'center' width = '300px' height = '300px'>
        <p>$row[3]</p>
        <p align = 'right'>Posted by: <a href = '$link'>$gn[0]</a>, Time: $row[5]</p>
      ";

      if($gn2[0]=='t'){
        $str = "delete.php?post_id=".$row[0]."&user_id=".$id;
        echo "<p align='left'><a href = '$str'>Delete Post</a></p></td>
        </tr>";
      }else{
        echo "</td></tr>";
      }
    }else{
      echo "
        <tr colspan='8'>
        <td align = 'center' colspan='8'>
        <b>$row[2]</b><br>
        <p>$row[3]</p>
        <p align = 'right'>Posted by: <a href = '$link'>$gn[0]</a>, Time: $row[5]</p>
      ";

      if($gn2[0]=='t'){
        $str = "delete.php?post_id=".$row[0]."&user_id=".$id;
        echo "<p align='left'><a href = '$str'>Delete Post</a></p></td>
        </tr>";
      }else{
        echo "</td></tr>";
      }
    }
  }
  echo "</table>";
?>
