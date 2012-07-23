<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'dashboard-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnType'=>true,
	),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'user_id',array('value'=>Yii::app()->user->id)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span3','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'content',array('rows'=>4, 'cols'=>30, 'class'=>'span3')); ?>
	
	<?php echo $form->textAreaRow($model,'render',array('rows'=>2, 'cols'=>30, 'class'=>'span3')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

