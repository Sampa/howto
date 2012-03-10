<?php
$this->breadcrumbs=array(
	'Steps'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Step', 'url'=>array('index')),
	array('label'=>'Create Step', 'url'=>array('create')),
	array('label'=>'Update Step', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Step', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Step', 'url'=>array('admin')),
);
?>

<h1>View Step #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'howto_id',
		'title',
		'text',
		'position',
		'author',
	),
)); ?>
