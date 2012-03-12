<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
?>

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
?>
	<div id="steps">
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?php echo $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		foreach ( $model->steps as $step ):
			echo CHtml::link( $step->title, array('/step/update?id=' . $step->id .'&howtoid=' . $model->id ) );
			echo '<br/><div class="well">' . $step->text .'</div>';
		
		
		 endforeach; 
		 ?>
	
	</div>
	
	
	<div id="comments">
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
