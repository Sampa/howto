<div class="form">

<?php 
	$form = $this->beginWidget('BootActiveForm', 
	array(
		'id'=>'howto-form',
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

	<?php     echo $form->errorSummary(array_merge(array($model),$validatedSteps));?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
	<?php echo $form->error($model,'content'); ?>
	<?php echo $form->textArea($model,'content',array('style'=>'display:block'));?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint">Please separate different tags with commas.</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('HowtoStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	
<?php 
	$stepFormConfig = array(
      'elements'=>array(
        'title'=>array(
            'type'=>'text',
            'maxlength'=>40,
        ),
        'text'=>array(
            'type'=>'textarea',
            'maxlength'=>6000,
			'class'=>'eltre',
        ),
        
    ));

	$this->widget('ext.multimodelform.MultiModelForm',
	array(
        'id' => 'id_step', //the unique widget id
        'formConfig' => $stepFormConfig, //the form configuration array
		'addItemText'=>'Add steps',
		'removeText' => 'Remove this step',
        'model' => $step, //instance of the form model
		'tableView'=>false,
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedSteps,
		'jsAfterClone'=>'$("#editorPlaceholder").load("/howto/eltre")',
		'sortAttribute' => 'position', //if assigned: sortable fieldsets is enabled
        //array of member instances loaded from db
        'data' => $step->findAll('howto_id=:howtoId', array(':howtoId'=>$model->id)),
    ));
?>


	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-primary' ) ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div id="editorPlaceholder"></div>
<?php $this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#Howto_content',
			'userid'=>Yii::app()->user->id,
		));
?>
<script>
$(document).ready(function(){
	$("#Step_text").hide();
	$("#Step_title").hide();
	$('label[for="Step_title"]').hide();
	$('label[for="Step_text"]').hide();

});

</script>