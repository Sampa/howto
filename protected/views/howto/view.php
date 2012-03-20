<?php
	$this->breadcrumbs = array( $model->title, );
	$this->pageTitle = $model->title;
	$this->layout = "column1";
?>
<div id="howto_container" style="padding-left: 20px; float:left;">
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
	
	
	<div id="steps" class="span7" style="clear:both; float:left;">
		<?php if ( $model->stepCount >= 1 ): ?>
			<h3>
				<?= $model->stepCount>1 ? $model->stepCount . ' steps' : 'One step'; ?>
			</h3>
		<?php endif; ?>
		<?php
		foreach ( $model->steps as $step ):
			echo CHtml::link( $step->title, array('/step/update?id=' . $step->id .'&howtoid=' . $model->id ) );
			echo '<br/><div class="well" ">' . $step->text .'</div>';
		 endforeach; 
		 ?>
	
	</div>


</div><!-- container-->
	<div id="comments" style="margin-top: 30px" class="span4" >
				<div id="disqus_thread"></div>
	</div><!-- comments -->