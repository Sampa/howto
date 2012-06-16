<?php
	$this->breadcrumbs=array(
		$model->username,
	);
		if (strtolower(Yii::app()->user->name) == strtolower($model->username))
		{
			$owner = true;
		}
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
	<h6>
	Joined on <?=$model->created;?> and last active <?=$model->last_activity;?>
	<?php $this->renderPartial('reputation',array('id'=>$model->id,'reputation'=>$model->reputation));?>
	</h6>
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


	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/inbox'">
		<?=$unreadCount;?> <i class="icon-white icon-envelope"></i>Inbox
	</button>
<!-- bookmarks button-->
	<?=  CHtml::ajaxLink('<i class="icon-bookmark icon-white"></i>inbox',
	array('//message/inbox'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary cc tool'));?>	
<!-- bookmarks button-->
	<?=  CHtml::ajaxLink('<i class="icon-bookmark icon-white"></i>Bookmarks',
	array('//bookmark/admin'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary cc tool'));?>
	
<!-- view your own howtos button -->
<?=  CHtml::ajaxLink('<i class="icon-book icon-white"></i>Your Howtos',
	array('/howto/admin'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary cc'));?>

<!-- social -->
	<?=  CHtml::ajaxLink('<i class="icon-user icon-white"></i> Social',
	array('social/index'),array('update'=>'#currentContent'),array('class'=>'btn btn-mini btn-primary cc'));?>
<!-- update -->
	<?= CHtml::link('<i class="icon-edit icon-white"></i> Your info',
	array('user/update/id/'.$model->id),array('class'=>'btn btn-mini btn-primary cc'));?>
<?php endif;?>
	</div>
	
<!-- the div which gets updated by the ajaxlinks above -->
<?php if($owner):?>

	<!-- current content -->
	<div id="currentContent" class="span well" style="display:none;position:relative;float:left;margin-left:0px; padding:10px;">
	</div>
<!-- presentation-->
	<div id="presentation_panel" style="display:none; clear:both;"></div>
	<div id="save_presentation_response" style="display:none	;">
		<?php
		Yii::app()->user->setFlash('success', 'Changes Saved');
		$this->widget('bootstrap.widgets.BootAlert'); 
		?>
	</div>
	
	
	<div id="presentation_text" class="span6 well" style="position:relative;float:left;margin-left:0px; padding:10px;">
<?= $model->presentation; ?>
	</div>
	<button class="btn btn-mini btn-success"  id="save_presentation" style="display:none;float:left;">
	<i class="icon-ok icon-white"></i>Save</button>
	

	<script type="text/javascript">
	
	$(".cc").click(function(){
		$("#currentContent").fadeIn('slow');
	});
	$("#presentation_text").click(function(){


			$("#save_presentation").fadeIn('slow');
			$("#presentation_panel").fadeIn('slow');
			
		});
	$("#save_presentation").click(function(){

			 var content = $("#presentation_text").html();
					url = '/yiiauth/user/updatefield';
					$.ajax({
					 type:"POST",
					  url: url,
					  dataType: 'json',
					  data: {content:content},
					  success: function(data) {
					if (data.status == 'success') {
						$("#save_presentation").fadeOut('slow');
						$("#presentation_panel").fadeOut('slow')
						$('#save_presentation_response').fadeIn('slow');			
						var pause = setTimeout("$('#save_presentation_response').fadeOut('slow')",5000);
					  return true;	
						
					}}
					});
				
		
		});
		$(document).ready(function(){
		var pres_editor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});

		pres_editor.setPanel('presentation_panel');
		pres_editor.addInstance('presentation_text');

		});
	</script>	
		<?php endif;?>

