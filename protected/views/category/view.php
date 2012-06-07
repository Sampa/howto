<?php
$this->breadcrumbs=array(
	$model->name,
);

?>
<h1>Howtos in the <?php echo $model->name; ?> category</h1>
<?php foreach($model->howtos as $howto){
	echo $howto->title;
}?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'parent',
	),
)); ?>
