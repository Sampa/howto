
	<div class="well">
	<h3>Share the knowledge!:)</h3>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'mailHowto-form',
    'htmlOptions'=>array('class'=>'well'),
)); 
?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('value'=>$this->user) ); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>2, 'cols'=>50) ); ?>
	</div>
		 <?php echo $form->hiddenField($model,'url',array('value'=>$url));?>

	<?php if(extension_loaded('gd')): ?>
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="row-fluid submit">
	    <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Send', array('class'=>'btn-tiny btn-success', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

