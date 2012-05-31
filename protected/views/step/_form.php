<div class="form">

<?php 
	$form = $this->beginWidget('BootActiveForm', array(
	'id'=>'step-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
		'clientOptions' =>
		array(
		  'validateOnSubmit'=>true,
		  'validateOnChange'=>true,
		  'validateOnType'=>true,
			 ),
 		'htmlOptions'=>array( 'class'=>'well' ),
		) );
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<div ="row-fluid">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div ="row-fluid">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text'); ?>
		
		<?php echo $form->error($model,'text'); ?>
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#Step_text',
			'userid'=>$this->userId,
		));
	?>
	</div>



	<div ="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-primary' ) ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->