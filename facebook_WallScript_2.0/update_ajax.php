
 <?php
include("db.php");
include("tolink.php");


if(isSet($_POST['content']))

{
$id=time();//Demo Use
$msg=$_POST['content'];
$sql=mysql_query("insert into messages(message)values('$msg')");
$result=mysql_query("select * from messages order by msg_id desc");
$row=mysql_fetch_array($result);
$id=$row['msg_id'];
$msg=$row['message'];
$msg=toLink($msg);
}


?>

 


<li class="bar<?php echo $id; ?>">
<div align="left" class="post_box">
<span style="padding:10px"><?php echo $msg; ?> </span>
<span class="delete_button"><a href="#" id="<?php echo $id; ?>" class="delete_update">X</a></span>
<span class='feed_link'><a href="#" class="comment" id="<?php echo $id; ?>">comment</a></span>
</div>
<div id='expand_box'>
<div id='expand_url'></div>
</div>
<div id="fullbox" class="fullbox<?php echo $id; ?>">
<div id="commentload<?php echo $id; ?>" >

</div>
<div class="comment_box" id="c<?php echo $id; ?>">
<form method="post" action="" name="<?php echo $id; ?>">
<textarea class="text_area" name="comment_value" id="textarea<?php echo $id; ?>">
</textarea><br />
<input type="submit" value=" Comment " class="comment_submit" id="<?php echo $id; ?>"/>
</form>
</div>
</div>


</li>