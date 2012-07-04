
<style type="text/css" media="all">

	#latestknowledge ul li 
	{
	display:inline;
		
	}

	</style>
<div class="span12" style="float:left;">
	<h2>Latest knowledge</h2>
	<div style="float:left; margin-top:10px;">
		<a class="next" href="#"><i class="icon-arrow-up"></i></a>
	<br/>
		<a class="prev" href="#"><i class="icon-arrow-down"></i></a>
	</div>
	<div class="" id="latestknowledge" style="min-height:300px;"> 

	<ul>
	<?php 
		$models = Howto::model()->findAll(array('order' => 'create_time DESC','limit'=>20));
		foreach ($models as $model):
	?>
		<li>
			<div class="span4" style="float:left;min-width:100%;margin-bottom:-10px;">		
			<?=CHtml::link(CHtml::encode($model->title), $model->url); ?>
			<!-- author link -->
				<div class="author">
					<div style="float:left;">
					Shared by	
					</div>
					<?php
						$this->widget('UserButton', 
							array(
							'id'=>$model->id,
							'userid'=>$model->author->id,
							'username'=>$model->author->username,
							'reputation'=>$model->author->reputation,
							)); 
					?>
			<!-- created and last updated dates-->
					<div >
						<?php $created = date('F j, Y @ H:m',$model->create_time); ?> on <i> <?=$created;?></i> 
					</div>
				</div>
			</div>
		</li>
		<?php endforeach;?>
</ul>
</div><!-- latest knowledge-->
</div>
<script type="text/javascript">
$(function(){
var $scroller = $("#latestknowledge");
$scroller.vTicker('init', { showItems: 10,animate:true});

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