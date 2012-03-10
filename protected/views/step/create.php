<?php
$this->breadcrumbs=array(
	'Steps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Step', 'url'=>array('index')),
	array('label'=>'Manage Step', 'url'=>array('admin')),
);
?>

<h1>Create Step</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>