<?php 
  require_once("includes/common.php"); 
  nav_start_outer("Transfer");
  nav_start_inner();
  if($_POST['submission']) {
	    $recipient = $_POST['recipient'];
    $zoobars = (int) $_POST['zoobars'];
    $sql = "SELECT Zoobars FROM Person WHERE PersonID=$user->id";
    $rs = $db->executeQuery($sql);
    $rs = mysqli_fetch_array($rs);
    $sender_balance = $rs["Zoobars"] - $zoobars;
    $sql = "SELECT PersonID FROM Person WHERE Username='$recipient'";
    $rs = $db->executeQuery($sql);
    $rs = mysqli_fetch_array($rs);
    $recipient_exists = $rs["PersonID"];

/*    $ref = ($_SERVER['HTTP_REFERER']);
    $tmp1 = substr($ref,strpos($ref,'//'+2));
    $tmp2 = substr($tmp1,0,strpos($tmp1,'/'));
    if($ref != 'www.myzoo.com' && $ref != 'localhost' && $tmp2 != 'localhost' && $tmp2 != 'www.myzoo.com'){
      //echo "<script>alert("Evil request!");</script>";
      die("Evil request!");
    }
 */
  //  echo $_POST["csrf"]."<br>";
  //  echo $_SESSION["csrf"]."<br>";
    $fail_flag=0;
    if($_SESSION["csrf"] != $_POST["csrf"]){
	    $fail_flag=1;
//	    echo "11111111111111111111";
    }
    if($zoobars > 0 && $sender_balance >= 0 && $recipient_exists&& $fail_flag==0 ){
	      
      $sql = "UPDATE Person SET Zoobars = $sender_balance " .
             "WHERE PersonID=$user->id";
      $db->executeQuery($sql);
      $sql = "SELECT Zoobars FROM Person WHERE Username='$recipient'";
      $rs = $db->executeQuery($sql);
	$rs = mysqli_fetch_array($rs);
      $recipient_balance = $rs["Zoobars"] + $zoobars;
      $sql = "UPDATE Person SET Zoobars = $recipient_balance " .
             "WHERE Username='$recipient'";
      $db->executeQuery($sql);
      $result = "Sent $zoobars zoobars";
    }
    else $result = "Transfer to $recipient failed.";
  }
?>
<p><b>Balance:</b>
<span id="myZoobars">  <?php 
  $sql = "SELECT Zoobars FROM Person WHERE PersonID=$user->id";
  $rs = $db->executeQuery($sql);
  $rs = mysqli_fetch_array($rs);
  $balance = $rs["Zoobars"];
  echo $balance > 0 ? $balance : 0;
?> </span> zoobars</p>
<form method=POST name=transferform
  action="<?php echo $_SERVER['PHP_SELF']?>">
<input type=hidden name=csrf value="<?php echo $_SESSION["csrf"]?>"/>
<p>Send <input name=zoobars type=text value="<?php 
  echo $_POST['zoobars']; 
?>" size=5> zoobars</p>
<p>to <input name=recipient type=text value="<?php 
  echo $_POST['recipient']; 
?>"></p>
<input type=submit name=submission value="Send">
</form>
<span class=warning><?php 
  echo "$result"; 
?></span>
<?php 
  nav_end_inner();
?>
<script type="text/javascript" src="zoobars.js.php"></script>
<?php
  nav_end_outer(); 
?>

