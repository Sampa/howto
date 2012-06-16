<div class="span3" style="float:left;margin-left:0px;max-width:150px; border:1px solid white;">
<?php 
	$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'liste',
	'stacked'=>false,
    'items'=>array(
        array('label'=>'Inbox', 'icon'=>'envelope', 'url'=>$this->createUrl('inbox/'),
				'active'=>true),
        array('label'=>'Sent', 'icon'=>'folder-close', 'url'=>$this->createUrl('sent/') ),
        array('label'=>'New Message', 'icon'=>'pencil', 'url'=>$this->createUrl('compose/') ),
		),
	)); 
	
?>

</div>
