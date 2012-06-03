<div class="well" >
<?php 
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm',
	array(
		'id'=>'user-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnChange'=>true,
				'validateOnFocus'=>true,
				'validateOnType'=>true,
			),
		'htmlOptions'=>array( 'class'=>'' ),
		)); 
?>	
	<div ="row-fluid buttons">
	<?php
		echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Save',
			array('class'=>'btn btn-mini btn-success', 'type'=>'submit') ); 
	?>
	</div>
	
	
<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'avatar',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	
	<?php echo $form->hiddenField($model,'id', array( 'value'=>$model->id ) );?>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',
			array( 'size'=>60,'maxlength'=>128 ) ); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	
<?php 
	if ( $model->isNewRecord ) :
?>
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
	
<?php endif;?>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row-fluid" >
		<?php echo $form->labelEx($model,'presentation');?>
		<?php echo $form->textArea($model,'presentation',array('display'=>'none'));?>
		<?php echo $form->error($model,'presentation');?>
	</div>
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#User_presentation',
			'userid'=>Yii::app()->user->id,
		));
	?>
<?php $this->endWidget(); ?>

</div><!-- form -->