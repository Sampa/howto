	<style type="text/css">
	.holder{padding:10px;background-color:#fff; display:none;margin-left:50px;width:340px;}
	.area{
	min-width:300px;min-height:50px; border-top:0px;
	}

	</style>

<?php foreach($comments as $comment): 
		$user = User::model()->find("username='".$comment->author."'");
		if(!$user)
			continue;
		if($comment->response_id !== null)
			continue;
?>
<div class="comment" id="c<?php echo $comment->id; ?>">

	<?php echo CHtml::link("#{$comment->id}", $comment->getUrl($howto), array(
		'class'=>'cid',
		'title'=>'Permalink to this comment',
	)); ?>

	<div class="author">
	
			<?php
			$this->widget('UserButton', 
				array(
				'id'=>$user->id,
				'userid'=>$user->id,
				'username'=>$user->username,
				'reputation'=>$user->reputation,
				)); 
				 
				?> 
	<div class="time">
		<?php echo date('F j, Y \a\t h:i a',$comment->create_time); ?>

	</div>

	</div>
	<?php 
	if(!Yii::app()->user->isGuest){
	$this->widget('BootButton', array(
		'buttonType'=>'button',
		'type'=>'primary',
		'size'=>'mini',
		'label'=>'Reply',
		'toggle'=>true,
		'icon'=>'white repeat',
		'htmlOptions'=>array('style'=>'float:left; margin-left:-75px;','class'=>'reply_button',
		'id'=>$comment->id)
		)); 
	}
	?>
	
	<div class="">
		<?php echo $comment->content; ?>
	</div>		
	
</div><!-- comment -->
	<!--responses-->
<?php $responses = Comment::model()->findAll('response_id='.$comment->id);
if($responses):?>
<div style="width:70%; margin-left:20%;" class="comment well">
<?php
		foreach($responses as $response){
		 		$user = User::model()->find("username='".$response->author."'");
		if(!$user)
			continue;
?>
	<?php echo CHtml::link("#{$response->id}", $response->getUrl($howto), array(
		'class'=>'cid',
		'title'=>'Permalink to this comment',
	)); ?>

	<div class="author">
			<?php
			$this->widget('UserButton', 
				array(
				'id'=>$user->id,
				'userid'=>$user->id,
				'username'=>$user->username,
				'reputation'=>$user->reputation,
				)); 
				 
				?> 
		<div class="time"><?php echo date('F j, Y \a\t h:i a',$response->create_time); ?></div>

	</div>

	
	<div class="">
		<?php echo $response->content; ?>
	</div>		
	
<?php		}
	?>
</div> 
<?php endif;?>
	<!-- reply -->
<div class="holder" id="holder<?=$comment->id;?>">
		<div id="comment_success<?=$comment->id;?>"></div>
		<div id="panel<?=$comment->id;?>"></div>
		<div id="area<?=$comment->id;?>" class="well area"></div>
		<?php $this->widget('BootButton', array(
		'buttonType'=>'button',
		'type'=>'success',
		'size'=>'mini',
		'label'=>'Comment',
		'icon'=>'white ok',
		'htmlOptions'=>array('style'=>'float:left; margin-top:-5px;','class'=>'send_reply',
		'name'=>$comment->id)
		)); ?>
</div>

	<script type="text/javascript">
	
//<![CDATA[
bkLib.onDomLoaded(function() {
	
var myNicEditor = new nicEditor();
myNicEditor.setPanel('panel<?=$comment->id;?>');
myNicEditor.addInstance('area<?=$comment->id;?>');

});
//]]>
</script>
<?php endforeach; ?>
<script type="text/javascript">
$(".send_reply").click(function(){
		var id = $(this).attr("name");	
		if(getCreate(<?php echo $comment->howto->id;?>,'#area'+id,id)){
		<?= Chtml::ajax(array('url'=>'/howto/reloadComments?howto_id='.$comment->howto->id,'update'=>'#current'));?>
		 $('#comment_success'+id).fadeIn('slow');
		
		}
	});
	$(".reply_button").click(function(){
		var id = $(this).attr("id");
		 $('#holder'+id).animate({
    opacity: 0.85,
    left: '+=50',
    height: 'toggle'
  }, 1000, function() {
    // Animation complete.
  });
  
		$("#holder"+id).fadeIn();
	
	});</script>