<div class="form" >
	 <h5> Upload videos </h5>
<div id="video"></div>
	 <?php 
	$XUpload = new XUploadForm;
	$this->widget('xupload.XUpload', 
			array(
					'url' => Yii::app()->createUrl("file/upload", 
					array("parent_id" =>User::USER_DIR . Yii::app()->user->id . '/video') ),
						'type'=>'video',
						'model' => $XUpload,
						'attribute' => 'file',
						'multiple'=>true,
						'options'=>array(
						'completed' => 'js:function (e,data) {
						$.each(data.files, function (index, file) {
						$("#Howto_video").val(\'\'+$("#Howto_video").val()+";"+file.name + \'\' );
						});
							}'),
		       ));

			   
?>

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
 		'htmlOptions'=>array( 'class'=>'well span5','style'=>'float:left;' ),
		) );
 ?>

	<?php     echo $form->errorSummary(array_merge(array($model),$validatedSteps));?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'video',array()); ?>
		<?php echo $form->error($model,'video'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row-fluid">
	<?php echo $form->error($model,'content'); ?>
	<?php echo $form->textArea($model,'content',array('style'=>'display:none'));?>
	<?php 
		$this->widget('application.extensions.elrte.elRTE', 
		array(
			'selector'=>'#Howto_content',
			'userid'=>Yii::app()->user->id,
		));
	?>
		
	</div>
	
	<div class="row-fluid">
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

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('HowtoStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	
	
	<div id="stepContainer" class="span3" style="display:block;">
<!-- add step--><button class="btn btn-primary" rel=".id_step_copy" href="#" id="id_step">
					<i class="icon-plus-sign icon-white"></i>Add step
				</button>
<?php 
	$stepFormConfig = array(
      'elements'=>array(
        'title'=>array(
            'type'=>'text',
            'maxlength'=>40,
        ),
        'text'=>array(
            'type'=>'textarea',
			'class'=>'elrte',
		
        ),
		 'howto_id'=>array(
            'type'=>'hidden',
            'maxlength'=>25,
        ),
        
    ));

	$this->widget('ext.multimodelform.MultiModelForm',
	array(
        'id' => 'id_step', //the unique widget id
        'formConfig' => $stepFormConfig, //the form configuration array
        'model' => $step, //instance of the form model
		'sortAttribute' => 'position', //if assigned: sortable fieldsets is enabled
		//'jsAfterClone'=>'testid("run");',
		//'jsAfterNewId'=>"",
		//'jsBeforeNewId' => "", 
	    'jsAfterNewId' => '',
		'tableView'=>false,
		'addItemText'=>'',
        //if submitted not empty from the controller,
        //the form will be rendered with validation errors
        'validatedItems' => $validatedSteps,
 
        //array of member instances loaded from db
        'data' => $step->findAll('howto_id=:howtoId', array(':howtoId'=>$model->id)),
    ));
?>

		
	
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-primary' ) ); ?>
	</div>

<?php $this->endWidget(); ?>
		</div><!-- stepContainer-->
	</div><!-- form -->
	
	
		<div id="stepContentArea" class="span5 well">
			<h2> Edit step <i id="thisstep">1</i> </h2>
				<?php 
					echo CHtml::textArea('stepcontent','',
					array( 'style'=>'clear:both' , 'id'=>'stepcontent' ) );
				?>
				<?php 
					$this->widget('application.extensions.elrte.elRTE', 
					array(
						'selector'=>'#stepcontent',
						'userid'=>Yii::app()->user->id,
					));
				?>
		</div>
		
<div id="currentStep" style="display:none;">Step_text</div>
	<script type="text/javascript">
$(document).ready(function(){

$('input[id*="Step"]').focus(function(){
	console.log($(this).attr("id"));
	var step_title_id = $(this).attr("id");
	var _number = step_title_id.substring(10);
	if (_number > 1){
		step_textarea_id = 'Step_text'+_number;
	}else{
		var step_textarea_id = 'Step_text';
		var _number = 1;
	}
	var before = $("#currentStep").html();
	$('#'+before).val($('#stepcontent').elrte('val'));
	$('#currentStep').html(step_textarea_id);
	$('#thisstep').html(_number);
	$('#stepcontent').elrte('val',$("#"+step_textarea_id).val());
	
});
});
</script>
