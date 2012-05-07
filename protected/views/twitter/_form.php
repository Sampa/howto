<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'twitter-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'consumer_key'); ?>
		<?php echo $form->textField($model,'consumer_key',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'consumer_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'consumer_secret'); ?>
		<?php echo $form->textField($model,'consumer_secret',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'consumer_secret'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->