<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
?>
<div id="howto_container" style="padding-left: 20px;">
	<div id="left" class="span7" style="float:left;" >
<?php 
	$this->renderPartial('_view',
	array(
		'data'=>$model,
	) ); 
?>
<?php // social plugin
	$this->widget('application.extensions.social.social', 
		array(
			'style'=>'horizontal', 
			'networks' => array(
				'twitter'=>array(
					'data-via'=>'', //http ://twitter.com/#!/YourPageAccount if exists else leave empty
					), 
				'googleplusone'=>array(
					'size'=>'medium',
					'annotation'=>'bubble',
				), 
				'facebook'=>array(
					'href'=>'https://www.facebook.com/your_facebook_page',//asociate your page http://www.facebook.com/page 
					'action'=>'recommend',//recommend, like
					'colorscheme'=>'light',
					'width'=>'130px',
					)
				)
			)
		);
?> 	 	</div><!--left-->
	<div id="right" class="span6" style="margin-left:60px;"  >
	<?php $this->widget('bootstrap.widgets.BootCarousel', array(
		'items'=>array(
			array('image'=>'http://placehold.it/770x400&text=First+thumbnail', 'label'=>'First Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
			array('image'=>'http://placehold.it/770x400&text=Second+thumbnail', 'label'=>'Second Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
			array('image'=>'http://placehold.it/770x400&text=Third+thumbnail', 'label'=>'Third Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
		),
		'events'=>array(
			'slide'=>"js:function() { console.log('Carousel slide.'); }",
			'slid'=>"js:function() { console.log('Carousel slid.'); }",
		),
	)); ?>

			lorum något annat här ipsum lorum något annat här ipsum
			lorum något annat här ipsum lorum något annat här ipsum
			lorum något annat här ipsumlorum något annat här ipsum
			lorum något annat här ipsumlorum något annat här ipsumlorum
			lorum något annat här ipsumlorum något annat här ipsum
			lorum något annat här ipsumlorum något annat här ipsum
			lorum något annat här ipsumlorum något annat här ipsumlorum något annat här ipsum
	</div>
	
	<div id="steps" class="span7" style="clear:both; float:left;">
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?php echo $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		foreach ( $model->steps as $step ):
			echo CHtml::link( $step->title, array('/step/update?id=' . $step->id .'&howtoid=' . $model->id ) );
			echo '<br/><div class="well" ">' . $step->text .'</div>';
		 endforeach; 
		 ?>
	
	</div>



	<div id="comments" style="" class="span5" >
		<?php if($model->commentCount>=1): ?>
		<h3>
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h3>

		<?php $this->renderPartial('_comments',array(
			'howto'=>$model,
			'comments'=>$model->comments,
		)); ?>
	<?php endif; ?>

	<h3>Leave a Comment</h3>

	<?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
		</div>
	<?php else: ?>
		<?php $this->renderPartial('/comment/_form',array(
			'model'=>$comment,
		)); ?>
	<?php endif; ?>

	</div><!-- comments -->
</div><!-- container-->