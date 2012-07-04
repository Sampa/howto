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
	$imageUrl = User::USER_DIR.$model->id."/".$model->avatar;
	?>
<div  style=" float:left;">
	<div class="well" id="user-bootmenu">
<?php 
	if($owner){
		if ( Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) > 0 )
		{
			$unreadCount = '(' . Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) . ')'; 
		}else{
			$unreadCount = false;
		}			
		$this->widget('bootstrap.widgets.BootMenu', array(
		'type'=>'list',
			'items'=>array(
				array('label'=>'Your Bookmarks', 'icon'=>'bookmark', 'url'=>'#loadBookmarks'),
				array('label'=>'Your Howtos', 'icon'=>'book', 'url'=>'#loadHowtos'),
				array('label'=>'Social Accounts', 'icon'=>'user', 'url'=>'#loadSocials'),
				array('label'=>'Settings', 'icon'=>'cog', 'url'=>'/update/id/'.$model->id),
				array('label'=>'Messages'),
				array('label'=>$unreadCount.'Inbox', 'icon'=>'envelope', 'url'=>'#loadInbox'),
				array('label'=>'Sent', 'icon'=>'folder-close', 'url'=>'#loadSent'),
				array('label'=>'New', 'icon'=>'pencil', 'url'=>'#loadCompose'),
			),
		)); 
	}else{//its a visitor
	$this->widget('UserButton', 
				array(
				'id'=>$model->id,
				'userid'=>$model->id,
				'username'=>$model->username,
				'reputation'=>$model->reputation,
				'profileLink'=>false,
				)); 
			
	$this->widget('BootButton', array(
			'label'=>$model->howtoCount.' Howtos',
			'type'=>'success', 
			'size'=>'mini',
		'htmlOptions'=>array('style'=>'float:left;')));
		
		$this->renderPartial('reputation',array('id'=>$model->id,'reputation'=>$model->reputation));
		}
	?>

	<br/><br/>
	<h6>
	Member since <?=$model->created;?>
	</h6>
	</div>

	
	<!--avatar html-->
	<a target="_blank" rel="fbox" href="<?=$imageUrl;?>">
		<img class="user_avatar"  style="width:250px; height:250px;" 
		src="<?=User::USER_DIR.$model->id."/thumb_".$model->avatar;?>" alt="Avatar"/>
	</a>	
	<!--END AVATAR -->
</div>
	<div class="span9">
	
	</div>
<div id="user_right" class="span6" style="margin-left:10px;">
	<?php if($owner):?>
<!-- presentation-->
	<div id="presentation_panel" style="display:none; clear:both;"></div>
	<div id="save_presentation_response" style="display:none	;">
		<?php
		Yii::app()->user->setFlash('success', 'Changes Saved');
		$this->widget('bootstrap.widgets.BootAlert'); 
		?>
	</div>
	<i class="icon-edit edit_pres" title="edit" style="position:relative; top:12px; left:98%;"></i>
	<?php endif;?>
	
	<div id="presentation_text" class="span12 well edit_pres" style="float:left;margin-left:0px; padding:10px;">

	<?= $model->presentation; ?>

	</div>
	
	<button class="btn btn-mini btn-success"  id="save_presentation" style="display:none;float:left;">
	<i class="icon-ok icon-white"></i>Save</button>
<!-- end presentation-->

</div><!-- div right -->
<!-- latest activities to the right -->
<?php $this->renderPartial('_activity',array('model'=>$model));?>

	<!-- current content -->
	<div id="currentcontentholder" class="span8 well" style="display:none;position:absolute; top:123px;left:260px;margin-left:0px; padding:10px;">
		<a id="closecontent"><i class="icon-remove" ></i></a>
		<div id="currentContent"></div>
	</div>

	
<?php if($owner):?>

	<script type="text/javascript">

	$(".edit_pres").click(function(){


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
		
		var pres_editor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});

		pres_editor.setPanel('presentation_panel');
		pres_editor.addInstance('presentation_text');

	</script>	
<?php endif;?>
<script type="text/javascript">
$(document).ready(function(){
			$("#closecontent").click(function(){
			$("#currentcontentholder").hide();
		});

	$('#user-bootmenu li a').click(function(){
		var href = $(this).attr('href');
		var foo = href.charAt('0');
		if(foo == "#"){
			$("#currentcontentholder").show('');
			switch(href){
				case "#loadBookmarks":
				loadBookmarks();
				break;
				case "#loadHowtos":
				loadHowtos();
				break;
				case "#loadSocials":
				loadSocials();
				break;
				case "#loadCompose":
				loadCompose();
				break;
				case "#loadInbox":
				loadInbox();
				break;
				case "#loadSent":
				loadSent();
				break;
			};
		}
	});	
	
		function loadBookmarks(){
		<?php echo Chtml::ajax(array('url'=>'/bookmark/admin','update'=>'#currentContent'));?>
	}
		function loadHowtos(){
		<?php echo Chtml::ajax(array('url'=>'/howto/admin','update'=>'#currentContent'));?>
	}
		function loadSocials(){
		<?php echo Chtml::ajax(array('url'=>'/yiiauth/social/index','update'=>'#currentContent'));?>
	}
		function loadCompose(){
		<?php
		$url = '/message/compose';
		if(!$owner)
			$url .="?id=".$model->id;			
		echo Chtml::ajax(array('url'=>$url,'update'=>'#currentContent'));?>
	}
		function loadSent(){
		<?php echo Chtml::ajax(array('url'=>'/message/sent','update'=>'#currentContent'));?>
	}
		function loadInbox(){
		<?php echo Chtml::ajax(array('url'=>'/message/inbox','update'=>'#currentContent'));?>
	}
	});
</script>