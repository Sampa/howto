<?php
$this->breadcrumbs=array(
	'Bookmarks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Bookmark','url'=>array('index')),
	array('label'=>'Create Bookmark','url'=>array('create')),
	array('label'=>'Update Bookmark','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Bookmark','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bookmark','url'=>array('admin')),
);
?>

<h1>View Bookmark #<?php echo $model->id; ?></h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'howto_id',
		'howto_title',
	),
)); ?>
