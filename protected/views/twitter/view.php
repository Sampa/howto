<?php
$this->breadcrumbs=array(
	'Twitters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Twitter', 'url'=>array('index')),
	array('label'=>'Create Twitter', 'url'=>array('create')),
	array('label'=>'Update Twitter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Twitter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Twitter', 'url'=>array('admin')),
);
?>

<h1>View Twitter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'consumer_key',
		'consumer_secret',
	),
)); ?>
