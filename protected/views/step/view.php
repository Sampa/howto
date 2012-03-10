<?php
	$this->breadcrumbs=array(
		'Steps'=>array('index'),
		$model->title,
	);

?>
	
	<?= CHtml::link('<i class="icon-print icon-white"></i>Print/Pdf', 
			array('/step/viewpdf/id/' . $model->id ), array('class'=>'btn btn-primary') );
	?>
	

	<h1><?php echo $model->title; ?> </h1>

	<div id="step_view_text" class="well">
		<?= $model->text; ?>
	</div>
	
	<?= CHtml::link('<i class="icon-arrow-left icon-white"></i>Howto', 
			array('/howto/view/id/' . $model->howto_id ), array('class'=>'btn btn-primary') );
	?>