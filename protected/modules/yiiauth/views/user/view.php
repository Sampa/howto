<?php
	$this->breadcrumbs=array(
		$model->username,
	);
?>
<!-- PHP--><?php

	$imageUrl ="";
	$imageUrl = "/files/users/".$model->id."/".$model->avatar;
	?>
	<div  style="width:100%; max-height:160px; float:left; border:0px solid blue;">
	<!--avatar html-->
	<a target="_blank" href="<?=$imageUrl;?>">
		<img class="user_avatar" style="min-width:100%;max-height:160px;" src="<?=$imageUrl;?>" alt="Avatar"/>
	</a>
	<!--END AVATAR -->
	</div>
	<?php $this->renderPartial('reputation',array('id'=>$model->id,'reputation'=>$model->reputation));?>
	<div id="navbar" style="clear:both;">
	<br/>
<!-- Send PM for visitors -->
	<?php if(!$owner):?>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/compose?id=<?=$model->id;?>'">
		<i class="icon-white icon-envelope"></i> Send PM
	</button>
	<?php endif;?>

<!-- if u visit your own profile show some other stuff -->	
<?php if($owner):?>
<?php 
	if ( Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) > 0 )
	{
		$unreadCount = '(' . Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) . ')'; 
	}else{
		$unreadCount = false;
	}			
?>
<!-- inbox button -->
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/inbox'">
		<?=$unreadCount;?> <i class="icon-white icon-envelope"></i>Inbox
	</button>
	
<!-- bookmarks button-->
	<?=  CHtml::ajaxLink('<i class="icon-bookmark icon-white"></i>Bookmarks',
	array('//bookmark/admin'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary tool'));?>
	
<!-- view your own howtos button -->
<?=  CHtml::ajaxLink('<i class="icon-book icon-white"></i>Your Howtos',
	array('/howto/admin'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary'));?>
<!-- update profile button-->
<?=  CHtml::ajaxLink('<i class="icon-refresh icon-white"></i>Update Info',
	array('update?id='.Yii::app()->user->id),array('update'=>'#currentContent'),
	array('class'=>'btn btn-mini btn-primary update_toggle','id'=>'update_button'));?>
<?php endif;?>
	</div>
	<div id="currentContent" class="span7 well" style="position:relative;border:0px solid red; margin-left:0px; padding:10px;">
	<?= $model->presentation; ?> 
	</div>


	<?php
	//$this->renderPartial('reputation',array('reputation'=>$model->reputation,'id'=>$model->id));?>

		<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#User_presentation',
			'userid'=>Yii::app()->user->id,
		));
	?>



	<script type="text/javascript">
	
		$(document).ready(function(){

		$("#reputation").click(function(){
			
		
		});
		});
	</script>	
