<?php
$this->breadcrumbs=array(
	'Manage how2',
);
?>
<div class="" style="padding-bottom:90px;"><h4>Your Howto's </h4>

<?php
	$this->widget('bootstrap.widgets.BootGridView', 
	array(
	'id'=>'howto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'name'=>'title',
				'type'=>'raw',
				'value'=>'CHtml::link( CHtml::encode( $data->title ), $data->url )',
			),

			array(
				'name'=>'status',
				'filter' => array('1' => 'Private', '2' => 'Public'), // filter
				'value'=>'$data->textStatus',

			),
			array(
				'name'=>'create_time',
				'type'=>'datetime',
				'filter'=>false,
			),
			array(
				 'class'=>'bootstrap.widgets.BootButtonColumn',
				 'template'=>'{view}{delete}',
				'htmlOptions'=>array( 'style'=>'width: 50px' ),
			),
		),
	)); 
?>
</div>