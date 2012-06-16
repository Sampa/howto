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

<h1><?php echo $model->title; ?></h1>
<h4><?=$model->text;?></h4>

<img src="/images/howto/<?=$model->howto_id;?>/slide/<?=$model->picture;?>"/>
