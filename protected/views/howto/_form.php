<div class="well span7" style="min-height:900px; " >
<h3>Share some knowledge!</h3>
<br/>
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
		<h4>Give your Howto a name</h4>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row-fluid" style="max-width:80%;">
	<h4> The description</h4>
	<?php Yii::app()->user->setFlash('info', '	The purpose of this Howto<br/>
	Is any Preparations needed?<br/> 
	And so on. After creating your Howto you can add steps in which you guide the user thrue 
	the Howto.');
		$this->widget('bootstrap.widgets.BootAlert'); 
		?>

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
	<h4> In which categories does this Howto belong?</h4>
	<?php //PRODUCTS MULTISELECT //
		$category = Category::model()->findAll('parent <> "no parent"');
        $categories = CHtml::listData($category, 'id', 'name'); // Get the list of options
        echo $form->dropDownList( $model,'categories', $categories,
                array(
                'multiple'=>'multiple',
                'key'=>'id',
                'class'=>'multiselect',
				) );?>
	<?php $this->widget(
      'application.extensions.emultiselect.EMultiSelect',
      array('sortable'=>true, 'searchable'=>true)
	);?>
	</div>
	<br/>
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-success' ) ); ?>
	</div>

<?php $this->endWidget(); ?>
<!--
	 <h5> Upload videos </h5>
<div id="video"></div>-->
	 <?php 
	// $XUpload = new XUploadForm;
	// $this->widget('xupload.XUpload', 
			// array(
					// 'url' => Yii::app()->createUrl("file/upload", 
					// array("parent_id" =>User::USER_DIR . Yii::app()->user->id . '/video') ),
						// 'type'=>'video',
						// 'model' => $XUpload,
						// 'attribute' => 'file',
						// 'multiple'=>true,
						// 'options'=>array(
						// 'completed' => 'js:function (e,data) {
						// $.each(data.files, function (index, file) {
						// $("#Howto_video").val(\'\'+$("#Howto_video").val()+";"+file.name + \'\' );
						// });
							// }'),
		       // ));

			   
?>

	</div><!-- form -->

