
<h4>Your Bookmarks</h4>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'bookmark-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'howto_title',
		array(
			'class'=>'BootButtonColumn',
			'viewButtonUrl'=>'"/howto/".$data->howto_id."/".$data->howto_title;', // a PHP expression for generating the URL of the button
			'template'=>'{view}{delete}',
		),
	),
)); ?>
