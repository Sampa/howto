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
	<?php if($owner):?>
	<div class="well">
<?php 
	if ( Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) > 0 )
	{
		$unreadCount = '(' . Yii::app()->getModule('message')->getCountUnreadedMessages($this->userId) . ')'; 
	}else{
		$unreadCount = false;
	}			

	?>

	<?php $this->widget('bootstrap.widgets.BootMenu', array(
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
)); ?>
</div>
	<script type="text/javascript">

	$('.nav li a').click(function(){
		var href = $(this).attr('href');
		var foo = href.charAt('0');
		if(foo == "#"){
			$("#currentcontentholder").fadeIn('');
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
		<?php echo Chtml::ajax(array('url'=>'/message/compose','update'=>'#currentContent'));?>
	}
		function loadSent(){
		<?php echo Chtml::ajax(array('url'=>'/message/sent','update'=>'#currentContent'));?>
	}
		function loadInbox(){
		<?php echo Chtml::ajax(array('url'=>'/message/inbox','update'=>'#currentContent'));?>
	}
	</script>
	<?php endif; //owner?>
	
	
	<!--avatar html-->
	<a target="_blank" href="<?=$imageUrl;?>">
		<img class="user_avatar" style="width:250px; height:250px;" src="<?=$imageUrl;?>" alt="Avatar"/>
	</a>
	<!--END AVATAR -->
</div>
	<div class="span9">
		<h6>
			<?=$model->username;?> Joined on <?=$model->created;?> and last active <?=$model->last_activity;?>
			<?php $this->renderPartial('reputation',array('id'=>$model->id,'reputation'=>$model->reputation));?>
			
			Has written <?= $model->howtoCount;?> Howtos
		</h6>
	</div>
<div id="user_right" class="span6" style="margin-left:10px;">

<!-- presentation-->
	<div id="presentation_panel" style="display:none; clear:both;"></div>
	<div id="save_presentation_response" style="display:none	;">
		<?php
		Yii::app()->user->setFlash('success', 'Changes Saved');
		$this->widget('bootstrap.widgets.BootAlert'); 
		?>
	</div>
	
<div id="presentation_text" class="span12 well" style="float:left;margin-left:0px; padding:10px;">
<?= $model->presentation; ?>
	</div>
	<button class="btn btn-mini btn-success"  id="save_presentation" style="display:none;float:left;">
	<i class="icon-ok icon-white"></i>Save</button>
</div><!-- div right -->
	<style type="text/css" media="all">
	#latestActivity
	{
		min-height:400px;
		margin-left:20px;
		margin-top: 5px;
		width:250px;
	}

	#latestActivity ul li 
	{
		min-height:50px;
		min-width:250px;

		
	}
	.action_title{
	padding-left:5px;
	background:#0088CC;
	color:#fff;
	}
	.action_title a{
	color:#fff;
	}
	</style>
<div id="activity_holder" style="margin-left:10px; float:left;">
	<div style="float:left; margin-top:10px;">
		<a class="next" href="#"><i class="icon-arrow-up"></i></a>
	<br/>
		<a class="prev" href="#"><i class="icon-arrow-down"></i></a>
	</div>
	
	<div  id="latestActivity" style=" ">

		<ul style="clear:both;">
		<?php foreach($model->actions as $action):?>
			<li>
				<div class="action_title span12"><h4><?=$action->title;?></h4></div>
				<div class="well">
				<?=$action->content;?>
				</div>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
</div>

<script type="text/javascript">
$(function(){
var $scroller = $("#latestActivity");
$scroller.vTicker('init', {height: 20, showItems: 10,animate:true});

$(".next").click(function(event){
event.preventDefault();
$scroller.vTicker('next');
});
$(".prev,.next").hover(function(){
$scroller.vTicker('pause', true);
}, function(){
$scroller.vTicker('pause', false);
});
$(".prev").click(function(event){
event.preventDefault();
$scroller.vTicker('prev');
});
});
</script>


<!-- user_left -->
<div id="user_left" style="float:left;" class="span7">
	
<!-- Send PM for visitors -->
	<?php if(!$owner):?>
	<button class="btn btn-mini btn-primary"
	onClick="window.location.href = '/message/compose?id=<?=$model->id;?>'">
		<i class="icon-white icon-envelope"></i> Send PM
	</button>
	<?php endif;?>
<!-- if u visit your own profile show some other stuff -->	
</div>
	<!-- current content -->
	<div id="currentcontentholder" class="span8 well"
	style="display:none;position:absolute; top:123px;left:260px;margin-left:0px; padding:10px;">
		<a id="closecontent"><i class="icon-remove" ></i></a>

		<div id="currentContent"></div>
	</div>




<?php if($owner):?>

	<script type="text/javascript">

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
			$("#closecontent").click(function(){
			$("#currentcontentholder").hide();
		});
		var pres_editor = new nicEditor({uploadURI:'/nic/upload.php?hej=<?=$model->id;?>'});

		pres_editor.setPanel('presentation_panel');
		pres_editor.addInstance('presentation_text');

		});
	</script>	
		<?php endif;?>
