<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consumer_key')); ?>:</b>
	<?php echo CHtml::encode($data->consumer_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consumer_secret')); ?>:</b>
	<?php echo CHtml::encode($data->consumer_secret); ?>
	<br />


</div>