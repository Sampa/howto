<?php
$this->breadcrumbs=array(
	'Create Howto',
);
?>
<h1>Share some knowledge!</h1>

<?php echo $this->renderPartial('_form', 
		array('model'=>$model,
			'step'=>$step,
			'validatedSteps'=>$validatedSteps,
			)); ?>