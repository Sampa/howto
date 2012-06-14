<div id="successDiv" style="display:none;">
<?php
Yii::app()->user->setFlash('success', 'Your comment was posted');
		$this->widget('bootstrap.widgets.BootAlert'); 
?>
</div>

	<div class="row-fluid">
		<div id="divComment" style="display:block;"></div>
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


<script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() {
	
var myNicEditor = new nicEditor();
myNicEditor.setPanel('divComment');
myNicEditor.addInstance('comment_content');

});
//]]>

$("#cButton").click(function(){

getCreate(<?php echo $howto->id;?>,'#comment_content');
$("#successDiv").fadeIn('slow');

<?= Chtml::ajax(array('url'=>'/howto/reloadComments?howto_id='.$howto->id,'update'=>'#current'));?>
});
</script>
