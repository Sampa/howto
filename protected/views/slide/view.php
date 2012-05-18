<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	$model->title,
);

/**$this->menu=array(
	array('label'=>'List ', 'url'=>array('index')),
	array('label'=>'Create ', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'id'=>$model->)),
	array('label'=>'Delete ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ', 'url'=>array('admin')),
);*/
?>

<h1>View <?php echo $model->title; ?></h1>

<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'text',
		array(
		'name'=>'picture',
		'type'=>'html', 
		'value'=>(!empty($model->picture))?CHtml::image("/images/howto/92/slide/".$model->picture,"panel  picture",array("style"=>"width:auto;height:auto;")):"no image"
	),
	),
)); ?>
