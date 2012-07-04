<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>9lessons Applicatio Demo</title>
<link href="frame.css" rel="stylesheet" type="text/css"><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script type="text/javascript" src="jquery.oembed.js"></script>
 
 <script type="text/javascript">


$(function() {

$(".comment_button").click(function() {

var element = $(this);
   
    var boxval = $("#content").val();
	
    var dataString = 'content='+ boxval;
	
	if(boxval=='')
	{
	alert("Please Enter Some Text");
	
	}
	else
	{
	$("#flash").show();
	$("#flash").fadeIn(400).html('<img src="ajax.gif" align="absmiddle">&nbsp;<span class="loading">Loading Update...</span>');
$.ajax({
		type: "POST",
  url: "update_ajax.php",
   data: dataString,
  cache: false,
  success: function(html){
 
  $("ol#update").prepend(html);
  $("ol#update li:first").slideDown("slow");
  
   document.getElementById('content').value='';
   $('#content').value='';
   $('#content').focus();
  $("#flash").hide();
  
    
	$("#expand_url").oembed(boxval);
	
  }
 });
}
return false;
	});


// delete undate
$('.delete_update').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({
		type: "POST",
  url: "delete_update.php",
   data: dataString,
  cache: false,
  success: function(html){
 
 $(".bar"+ID).slideUp();
	
  }
 });

}
return false;
});


//comment slide
$('.comment').live("click",function() 
{

var ID = $(this).attr("id");
$(".fullbox"+ID).show();
$("#c"+ID).slideToggle(300);

return false;
});


//commment Submint

$('.comment_submit').live("click",function() 
{

var ID = $(this).attr("id");

var comment_content = $("#textarea"+ID).val();
	
    var dataString = 'comment_content='+ comment_content + '&msg_id=' + ID;
	
	if(comment_content=='')
	{
	alert("Please Enter Comment Text");
	
	}
	else
	{
	
   
   	$.ajax({
		type: "POST",
  url: "comment_ajax.php",
   data: dataString,
  cache: false,
  success: function(html){
  
 
  $("#commentload"+ID).append(html);
    document.getElementById("textarea"+ID).value='';
   
   $("#textarea"+ID).focus();
  
  }
 });
	
	
	}

return false;
});

//comment delete
$('.cdelete_update').live("click",function() 
{
var ID = $(this).attr("id");

var dataString = 'com_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({
		type: "POST",
  url: "delete_comment.php",
   data: dataString,
  cache: false,
  success: function(html){
 
 $("#comment"+ID).slideUp();
	
  }
 });
}
return false;
});




return false;

});


</script>


<style type="text/css">
body
{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
.update_box
{
background-color:#D3E7F5; border-bottom:#ffffff solid 1px; padding-top:3px
}
a
	{
	text-decoration:none;
	color:#d02b55;
	}
	a:hover
	{
	text-decoration:underline;
	color:#d02b55;
	}
	*{margin:0;padding:0;}
	
	
	ol.timeline
	{list-style:none;font-size:1.2em;}ol.timeline li{ display:none;position:relative; }ol.timeline li:first-child{border-top:1px dashed #006699;}
	.delete_button
	{
	float:right; margin-right:10px; width:20px; height:20px
	}
	
	.cdelete_button
	{
	float:right; margin-right:10px; width:20px; height:20px
	}
	
	.feed_link
	{
	font-style:inherit; font-family:Georgia; font-size:13px;padding:10px; float:left; width:350px
	}
	.comment
	{
	color:#0000CC; text-decoration:underline
	}
	.delete_update
	{
	font-weight:bold;
	
	}
	.cdelete_update
	{
	font-weight:bold;
	
	}
	.post_box
	{
	height:55px;border-bottom:1px dashed #006699;background-color:#F3F3F3;  width:499px;padding:.7em 0 .6em 0;line-height:1.1em;
	
	}
	#fullbox
	{
	margin-top:6px;margin-bottom:6px; display:none;
	}
	.comment_box
	{
	    display:none;margin-left:90px; padding:10px; background-color:#d3e7f5; width:300px;  height:50px;
	
	}
	.comment_load
	{
	  margin-left:90px; padding:10px; background-color:#d3e7f5; width:300px; height:30px; font-size:12px; border-bottom:solid 1px #FFFFFF;
	
	}
	.text_area
	{
	width:290px;
	font-size:12px;
	height:30px;
	}
	#expand_box
	{
	margin-left:90px;
	margin-top:5px;
	margin-bottom:5px;
	}
	embed
	{
		width:200px;
		height:150px;

	}
	
</style>
</head>

<body>
<div style="padding:5px; background-color:#FFD987"><h3>Facebook Wall Script Application with exapanding URLs(Ver 2.0). Click all links and buttons (update, comment and delete)</h3></div>
<div style="padding:5px; "><h3>More tutorials : <a href="http://www.9lessons.info">9lessons.info</a> </h3>
</div>

<div align="center">
<table cellpadding="0" cellspacing="0" width="500px">
<tr>
<td>


<div align="left">
<form  method="post" name="form" action="">
<table cellpadding="0" cellspacing="0" width="500px">

<tr><td align="left"><div align="left">
<h4>Eg : <span style="background-color:#ffffcc; padding:5px"> Arjun Movie Trailor http://www.youtube.com/watch?v=5-EezcpFzVI</span></h4><br />
<h3>What are you doing?</h3></div></td></tr>
<tr>
<td style="padding:4px; padding-left:10px;" class="update_box">
<textarea cols="30" rows="2" style="width:480px;font-size:14px; font-weight:bold" name="content" id="content" maxlength="145" ></textarea><br />
<input type="submit"  value="Update"  id="v" name="submit" class="comment_button"/>
</td>

</tr>

</table>
</form>

</div>
<div style="height:7px"></div>
<div id="flash" align="left"  ></div>



<ol  id="update" class="timeline">



</ol>

</td>
</tr>
</table>






</div>


<iframe src="counter.html" frameborder="0" scrolling="no"></iframe>
</body>
</html>
