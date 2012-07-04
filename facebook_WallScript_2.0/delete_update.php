
<?php
include("db.php");
if($_POST['msg_id'])
{
$id=$_POST['msg_id'];
$id = mysql_escape_String($id);
$sql = "delete from messages where msg_id='$id'";
mysql_query( $sql);
}
?>