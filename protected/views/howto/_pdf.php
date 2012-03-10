<div class="Howto">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($model->title), $model->url); ?>
	</div>
	<div class="author">
		Posted by <?php echo $model->author->username . ' on ' . date('F j, Y',$model->create_time); ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $model->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?php echo $data->stepCount;?> Steps
		
	</div>
</div>

	<div id="steps">
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?php echo $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		foreach ( $model->steps as $step ):
			echo CHtml::link( $step->title, array('/step/view/id/' . $step->id ) );
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


	</div><!-- comments -->
