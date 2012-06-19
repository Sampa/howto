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
	color:#F5F5F5;
	}
	.action_title a{
	color:#fff;
	}
	</style>
<div id="activity_holder" style="margin-left:10px; float:left;">
<h4>Latest activity <?=$model->last_activity;?></h4>

	<div style="float:left; margin-top:10px;">
		<a class="next" href="#"><i class="icon-arrow-up"></i></a>
	<br/>
		<a class="prev" href="#"><i class="icon-arrow-down"></i></a>
	</div>
	
	<div  id="latestActivity" style=" ">

		<ul style="clear:both;">
		<?php foreach($model->actions as $action):?>
			<li>
				<div class="action_title span12">
					<h4><?=$action->title;?></h4>
					<span style="font-weight:bold;"><?=$action->created;?>
				</div>
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