
<?php
include("db.php");
if($_POST['com_id'])
{
$id=$_POST['com_id'];
$id = mysql_escape_String($id);
$sql = "delete from comments where com_id='$id'";
mysql_query( $sql);
}
?>