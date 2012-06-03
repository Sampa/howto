<?php
	$this->breadcrumbs=array(
		$model->username,
	);
?>
<!-- PHP--><?php

	$imageUrl ="";
	$imageUrl = "/files/users/".$model->id."/".$model->avatar;
	?>
	<div  style="width:60%; height:130px; float:left; border:1px solid blue;">
	<!--avatar html-->
	<a target="_blank" href="<?=$imageUrl;?>">
		<img class="user_avatar" style="max-height:160px;" src="<?=$imageUrl;?>" alt="Avatar"/>
	</a>
	<!--END AVATAR -->
	</div>
	<div id="navbar" style="clear:both;">
<!-- Message/inbox -->
	<?php if(!$owner):?>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/compose?id=<?=$model->id;?>'">
		<i class="icon-white icon-envelope"></i> Send PM
	</button>
	<?php endif;?>
	
<?php if($owner):?>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/compose'">
		<i class="icon-white icon-envelope"></i> New PM
	</button>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/inbox'">
		<i class="icon-white icon-envelope"></i> Inbox
	</button>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/Sent'">
		<i class="icon-white icon-envelope"></i> Sent
	</button>	
<!-- update-->
		<button class="update_toggle btn btn-mini btn-primary" id="update_button"">
			<i class="icon-ok icon-white"></i>Update
		</button> 
  
		<button class="update_toggle btn btn-mini btn-danger" id="cancel_button" style="display:none;">
<!--cancel--><i class="icon-ban-circle icon-white"></i>Cancel 
		</button>
<?php endif;?>
	</div>
	<?php
	//$this->renderPartial('reputation',array('reputation'=>$model->reputation,'id'=>$model->id));?>
	<?php 	if ( !Yii::app()->user->isGuest ): ?>
	<div id="user_update" class="span7" style="border:0px solid red;clear:both; margin-left:0px;">
<!--update form--><?=$this->renderPartial('update',array('model'=>$model));?>
	</div>
	<?php
	$this->beginWidget('system.web.widgets.CClipWidget', array( 'id'=>'sidebar' ) );  
		//the users own bookmarks
		$bookmarks = Bookmark::model()->getBookmarks($this->userId);
		if ( $bookmarks ):
	?> 
			<div class="well" style=""> <h2>Your Bookmarks</h2>
				<?php
					foreach( $bookmarks as $link )
					{
						echo $link . '<br/>';
					}
				?>
			</div>
	
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
<?php endif; endif; $this->endWidget(); ?>


	
<div id="user_presentation" class="span7 well" style="border: 0px solid black;clear:both; padding-right:0px;margin-left:0px;"> <?= $model->presentation; ?> </div>
