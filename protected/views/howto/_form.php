<div class="well" style="min-height:900px;" >

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
 		'htmlOptions'=>array( 'class'=>' span8','style'=>'float:left;' ),
		) );
 ?>

	<?php  echo $form->errorSummary(array($model));?>
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

	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-primary' ) ); ?>
	</div>

<?php $this->endWidget(); ?>
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

	</div><!-- form -->

