	<div style="min-width:500px;padding:0px;">
<?php 
	$form = $this->beginWidget('BootActiveForm',array(
		'id'=>'login-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnType'=>true,
			'validateOnChange'=>true,
		),
	)); 
?>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h2>Login</h2>
	</div>
	
	<div class="modal-body" style="float:left;">
		<div class="row-fluid">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row-fluid">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="row-fluid rememberMe">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>
	</div>

	<div style="position:relative;max-width:300px;float:left; ">
		<h4> Or use a social Provider </h4>
		<?php $this->widget('LoginWidget');?>

	</div>
	<div class="modal-footer">
		<?php echo CHtml::submitButton('Login',array('id'=>'log', 'class'=>'btn btn-primary','style'=>'float:left;')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

