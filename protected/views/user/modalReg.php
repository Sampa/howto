	<div class="" style="min-width:530px;padding:0px;">
<?php 
	$form = $this->beginWidget('BootActiveForm',array(
'id'=>'user-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnChange'=>true,
				'validateOnFocus'=>true,
				'validateOnType'=>true,
			),
	)); 
?>
	<div class="modal-header" style="max-width:500px;">
			<a class="close" data-dismiss="modal">&times;</a>
			<h2>Register</h2>
	</div>
	
	<div class="modal-body" style="float:left;">
	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'avatar',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	
	<?php echo $form->hiddenField($model,'id', array( 'value'=>$model->id ) );?>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',
			array( 'size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>
	

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	</div>

	<div style="position:relative;max-width:270px;float:left;">
		<?php $this->widget('LoginWidget');?>

	</div>
	<div class="modal-footer">
	<br style="clear:both;"/>
	<?php
		echo CHtml::htmlButton('<i class="icon-ok icon-white"></i>Sign up',
			array('class'=>'btn btn-primary', 'style'=>'float:left;', 'type'=>'submit') ); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

