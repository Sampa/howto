<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('howto_id')); ?>:</b>
	<?php echo CHtml::encode($data->howto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('howto_title')); ?>:</b>
	<?php echo CHtml::encode($data->howto_title); ?>
	<br />


</div>