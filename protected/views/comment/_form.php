<a href="#" id="leave_comment" style="margin-top:25px;" ><h3 >Leave a Comment</h3></a>

<div id="successDiv" style="display:none;">
<?php
Yii::app()->user->setFlash('success', 'Your comment was posted');
		$this->widget('bootstrap.widgets.BootAlert'); 
?>
</div>
	<div id="leave_comment_holder" style="display:none;">
		<div class="row-fluid" >
			<div id="divComment" ></div>
			<div id="comment_content" style="min-height:60px; min-width:250px;" class="well"	></div>
		</div>
		<div class="row-fluid buttons">
		<?php $this->widget('BootButton', array(
		'label'=>'Comment',
		'type'=>'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'size'=>'mini', // '', 'large', 'small' or 'mini'
		'icon'=>'ok white',
		'htmlOptions'=>array(	'id'=>'cButton'))
		); ?>

		</div>
	</div>


<script type="text/javascript">
$("#leave_comment").click(function(){
	$("#leave_comment_holder").fadeToggle();
	$("#comment_content").focus();

});
//<![CDATA[
bkLib.onDomLoaded(function() {
	
var myNicEditor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});
myNicEditor.setPanel('divComment');
myNicEditor.addInstance('comment_content');

});
//]]>

$("#cButton").click(function(){
if( $("#comment_content").html().length < 5){
alert('Common, 5 characters isn\'t that many, you could do atleast that!');
return
}
getCreate(<?php echo $howto->id;?>,'#comment_content');
$("#successDiv").fadeIn('slow');
$("#leave_comment_holder").fadeOut();
<?= Chtml::ajax(array('url'=>'/howto/reloadComments?howto_id='.$howto->id,'update'=>'#current'));?>
});
</script>
