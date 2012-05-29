<?php
	$this->breadcrumbs=array(
		$model->username,
	);
?>
	<h1><?=$model->username; ?></h1>
	<a class="btn btn-primary" href="/message/compose?id=<?=$model->id;?>">
		<i class="icon-white icon-envelope"></i> Message
	</a>
	<!-- update-->
	<?php if ( Yii::app()->user->id == $model->id ): ?>
		<button class="update_toggle btn btn-primary" id="update_button"">
			<i class="icon-ok icon-white"></i>Update
		</button> 
  
		<button class="update_toggle btn btn-danger" id="cancel_button" style="display:none;">
<!--cancel--><i class="icon-ban-circle icon-white"></i>Cancel 
		</button>

	<?php endif;?>
	<?=$this->renderPartial('reputation',array('reputation'=>$model->reputation,'id'=>$model->id));?>
	

<!--AVATAR PHP--><?php

	$imageUrl ="";
	$imageUrl = "/files/users/".$model->id."/".$model->avatar;
	?>
	<div  style="width:170px; height:130px; float:left;">
	<!--avatar html-->
	<a target="_blank" href="<?=$imageUrl;?>">
		<img class="user_avatar" style="max-height:130px;" src="<?=$imageUrl;?>" alt="Avatar"/>
	</a>
	<!--END AVATAR -->
	</div>
	
	
	<div id="profile_detail_view" style="width: 300px; border: 1 px solid black;">
<?php
	$this->widget('bootstrap.widgets.BootDetailView',
	array(
	'data'=>$model,
	'attributes'=>array(
		'email',
		'created',
		'last_activity',
		),
	'htmlOptions'=>array('style'=>'width: 300px'),
	)); 
?>
	</div>
	

	<div id="user_update" style="clear:both;">
<!--update form--><?=$this->renderPartial('update',array('model'=>$model));?>
	</div>



<div id="user_presentation" style="clear:both; margin-left:120px;"> <?= $model->presentation; ?> </div>

<?php if ( Yii::app()->user->id == $model->id || $model->public_library == User::PUBLIC_LIBRARY ): ?>
	<h4> <?= Yii::app()->user->id;?> file library  </h4>

<?php require('_fileLibrary.php'); ?>
<?php endif; ?>


<?php 
	$this->beginWidget('system.web.widgets.CClipWidget', array( 'id'=>'sidebar' ) );  
		echo "<h1> Profile Sidebar </h1>";
	$this->endWidget(); 
?>


	<script type="text/javascript">
		$(document).ready(function(){
			$("#user_update").hide();
		});
		$(".update_toggle").click(function(){
			$("#user_update").toggle();
			$("#user_presentation").toggle();
			$("#update_button").toggle();
			$("#cancel_button").toggle();
		});
		$("#reputation").click(function(){
			
		
		});
	</script>	

