<?php
  include("db.php");
  $id = $_GET['user_id'];
  $payURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
  $payID = "yogeshpro01-facilitator@gmail.com";
  if(isset($_POST['but'])){
    $amount = $_POST['amount'];
    $qer = "insert into payments (txn_id,user_id,amount,payment_status) VALUES ('$id','$amount','true')";
    $q2 = "select donation from users where user_id = '$id' ";
    $r1 = pg_query($db,$q2);
    $row1 = pg_fetch_row($r1);
    $new_amount = $row1[11] + $amount ;
    $q3 = "update users set donation = '$new_amount' where user_id = '$id' ";
    $qup1 = pg_query($db,$q3);
    $qup2 = pg_query($db,$qer);
  }
?>

<html>
  <head>
    <title> Donate </title>
  </head>
  <body bgcolor = "skyblue">
    <form action = "<?php echo $payURL; ?>" method = "POST">
      <input type = "hidden" name = "business" value = "<?php echo $payID; ?>">
      <input type = "hidden" name = "cmd" value = "_xclick">
      <input type = "hidden" name = "amount" value = "<?php $amount; ?>">
      <input type="hidden" name="currency_code" value="USD">

      <table align = "center" width = "40%" border = "2" bgcolor = "orange">
        <tr align = "center">
          <td colspan = "8"><h2> Donate </h2> </td>
        </tr>
        <tr>
          <td align = "center">Amount (USD): </td>
          <td align = "center"> <input type = "text" name = "amount" size = "60" required/></td>
        </tr>
        <tr align = "center">
					<td colspan="8"> <input type = "submit" name = "but" value = "Proceed with Paytm" /> </td>
				</tr>
      </table>
    </form>
  </body>
</html>
