<?php
$this->breadcrumbs=array(
	'Steps'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Step', 'url'=>array('index')),
	array('label'=>'Create Step', 'url'=>array('create')),
	array('label'=>'View Step', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Step', 'url'=>array('admin')),
);
?>

<h1>Update Step <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>