<?php
$this->breadcrumbs=array(
	'Users',
);


?>

<h2>Users</h2>

<?php $this->widget('BootListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
