<div class="span7 well" style="padding-right:0px;margin-left:0px; margin-top:10px;">

<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="well">
<?php $form=$this->beginWidget('BootActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with  <tt>admin/admin</tt>.
		</p>
	</div>

	<div class="row-fluid rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row-fluid submit">
	    <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Login', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>