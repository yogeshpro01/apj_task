  <?php
    include("db.php");
    $id = $_GET['user_id'];
    $qm = "select * from users where user_id = '$id'  ";
    $q = pg_query($db,$qm);
    $row = pg_fetch_row($q);
  ?>

  <html>
    <head>
      <title><?php echo $row[1]; ?></title>
    </head>
    <body bgcolor = "skyblue">
      <table align = "center" width = "60%" border = "2" bgcolor = "orange">
        <tr align = "center">
          <td colspan="8"> <h2> <?php echo $row[1]; ?> </h2> </td>
        </tr>
        <tr align = "center">
          <td colspan="8"> <img src = "images/users/<?php echo $row[4];?>" width="200px" height = "200px" align = "center" margin = "5px"></td>
        </tr>
        <tr>
					<td align="center"> First name: </td>
					<td> <?php echo $row[5]; ?></td>
				</tr>
        <tr>
					<td align="center"> Surname: </td>
					<td>  <?php echo $row[6]; ?></td>
				</tr>
        <tr>
					<td align="center"> Age: </td>
					<td>  <?php echo $row[7]; if($row[7]==NULL){echo "N/A";}?> </td>
				</tr>
        <tr>
					<td align="center"> Email: </td>
					<td>
             <?php echo $row[8]; ?></td>
					</td>
				</tr>
        <tr>
					<td align="center"> Donation: </td>
					<td> <?php echo $row[11]; ?></td>
				</tr>
				<tr>
					<td align="center"> Bio: </td>
					<td> <?php echo $row[9]; ?></td>
				</tr>
        <tr>
          <td colspan="8"> <b>Posts:</b> </td>
        </tr>
    </body>
  </html>

  <?php
    $query = "select * from posts where user_id = '$id' ";
    $gq = pg_query($db,$query);
    if(pg_num_rows($gq) == 0){
      echo "<tr><td colspan='8'>No posts yet.</td></tr></table> ";
    }
    while($row = pg_fetch_array($gq)){
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
          <p align = 'right'>Time: $row[5]</p>
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
          <p align = 'right'>Time: $row[5]</p>
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
