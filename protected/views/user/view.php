<?php
	$this->breadcrumbs=array(
		$model->username,
	);
?>
	<h1><?=$model->username; ?></h1>
	<a class="btn btn-primary" href="/message/compose?id=<?=$model->id;?>">
		<i class="icon-white icon-envelope"></i> Message
	</a>
	
<!-- FACEBOOK INFO -->

	 <?php

	$userid = $model->facebook;
	
	if ( $userid )
	{ 
	$imageUrl = Yii::app()->facebook->getProfilePictureById($userid);
	$fql = 'SELECT name,username from user where uid = ' . $userid;
        $facebook = Yii::app()->facebook->api(array(
                                   'method' => 'fql.query',
                                   'query' => $fql,
                                 ));
        // FQL queries return the results in an array, so we have
        //  to get the user's name from the first element in the array.
       	?>

	<h5>
		Visit <a target="_blank" href="http://www.facebook.com/<?=$model->facebook;?>"><?= $facebook[0]['name']?></a>
		<?php if ( $facebook['0']['username'] !== "")
				echo " ( also known as ". $facebook['0']['username'] . ")";?>
		on facebook 
	</h5>

	<?php
	}
	else { $imageUrl = User::USER_DIR . $model->id . '/' . $model->avatar;}
	
	?>
	


	
	<div  style="width:170px; height:130px; float:left;">
		<a target="_blank" href="<?= User::USER_DIR . $model->id . '/' . $model->avatar;?>">
<!--avatar--><img class="user_avatar"
			src="<?=$imageUrl;?>" 
			alt="Avatar"/>
		</a>
<!-- update--><?php if ( Yii::app()->user->id == $model->id ): ?>
		<button class="update_toggle btn btn-primary" id="update_button" style="float:left;">
			<i class="icon-ok icon-white"></i>Update
		</button> 
  
		<button class="update_toggle btn btn-danger" id="cancel_button" style="float:left; display:none;">
<!--cancel--><i class="icon-ban-circle icon-white"></i>Cancel 
		</button>

	</div>
	<?php endif;?>	
	
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



<div id="user_presentation" style="clear:both"> <?= $model->presentation; ?> </div>

<?php if ( $this->userId == $model->id || $model->public_library == User::PUBLIC_LIBRARY ): ?>
	<h4> <?= $this->user;?> file library  </h4>

<?php //require('_fileLibrary.php'); ?>
<?php endif; ?>


<?php 
	$this->beginWidget('system.web.widgets.CClipWidget', array( 'id'=>'sidebar' ) );  
//<!--user howtos-->
	if ( $model->howtos ):
			echo '<div class="well"><h2> Howtos by ' . $model->username . "</h2>";
			foreach( $model->howtos as $howto ) 
			{
				echo Howto::model()->getLink($howto->id);
				echo "<br/>";
			}
			echo '</div>';	
	endif;	
	$this->endWidget(); 
?>


	<script>
		$(document).ready(function(){
			$("#user_update").toggle();
		});
		$(".update_toggle").click(function(){
			$("#user_update").toggle();
			$("#user_presentation").toggle();
			$("#update_button").toggle();
			$("#cancel_button").toggle();
		});
	</script>	

