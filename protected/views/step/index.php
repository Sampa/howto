<?php
$this->breadcrumbs=array(
	'Steps',
);

$this->menu=array(
	array('label'=>'Create Step', 'url'=>array('create')),
	array('label'=>'Manage Step', 'url'=>array('admin')),
);
?>

<h1>Steps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
