<div class="well">
<h4> Add a new step to your How2 </h4>

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
 		'htmlOptions'=>array( ),
		) );
?>


	<?php echo $form->errorSummary($model); ?>



	<div class="row-fluid">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row-fluid">
		<div id="Step_panel" style="min-width:500px;"></div>
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('class'=>'well','style'=>'min-width:100%; min-height:150px; max-height:300px;'));?>		
		<?php echo $form->error($model,'text'); ?>

	</div>

<script>
$().ready(function(){
});
</script>
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-success' ) ); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->
