<?php
$this->breadcrumbs=array(
	'Bookmarks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bookmark','url'=>array('index')),
	array('label'=>'Create Bookmark','url'=>array('create')),
	array('label'=>'View Bookmark','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Bookmark','url'=>array('admin')),
);
?>

<h1>Update Bookmark <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>