
<div class="well" style="position:relative;min-height:900px;border:0px solid black; " >
<h3>Share some knowledge!</h3>
<br/>

<div style="float:left; border:0px solid green; padding-right:0px;" class="span6">

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
 		'htmlOptions'=>array( 'class'=>'span8','style'=>'float:left;' ),
		) );
 ?>

	<?php  echo $form->errorSummary(array($model));?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'video',array()); ?>
		<?php echo $form->error($model,'video'); ?>
	</div>

	<div class="row-fluid">
		<h4>Give your Howto a name
			<?php $this->widget('Question',array('content'=>'Try to pick a title that well describes what the howto is about,
						so other users easily can see if it\'s for them '));?>

		</h4>

		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	
	</div>

	<div class="row-fluid" style="width:500px;">

		<h4>The description
			<?php $this->widget('Question',array('content'=>'After creating your Howto you can add steps in which you guide the user thrue the Howto.
						But here you make the description of the howto, get people interested;)
						<ul>
							<li>Is any Preparations needed?</li>
							<li>Where can one read more?</li>
							<li>Will you give support and answer questions?</li>
						</ul> '));?>

		</h4>
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
	
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', 
			array( 'class'=>'btn btn-success' ) ); ?>
	</div>
</div>

	<div class="span5" style="float:left; border:0px solid red; margin-right:50px;">
<div class="row-fluid" >

		<h4>Tags
		<?php $this->widget('Question',array('content'=>'Tags are used to in one word point out more exactly what the Howto is about,<br/>
		making it more likely to attract viewers.<br/>
		<b>For example: Pizza,easy,Recipe</b>'));?>
		</h4>
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
	<div class="row-fluid" >		
	<h4> Categories
	<?php $this->widget('Question',
		array('content'=>'Select one or more categories that is <b>the most</b> suiting for your Howto<br/>
Obviously misplaced Howtos will be removed.'));?>
	</h4>
	<?php 
		$category = Category::model()->findAll('parent <> "no parent"');
		$categories = CHtml::listData($category, 'name', 'name'); // Get the list of options
		$this->widget('ext.select2.ESelect2',array(
		  'model'=>$model,
		  'attribute'=>'categories',
		  'data'=>$categories,
		  'multiple'=>true,
		  'htmlOptions'=>array('class'=>'ac_input')
		)); 
	?>		
</div>

	<?php $this->endWidget();?>
	<div class="" style="position:relative;top:10px;left:00px; min-width:200px; display:none;">

	 <h4> Upload videos </h4>
	 <p class="note">Only mp4 format supported
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
						'acceptFileTypes'=>'/(\.|\/)(mp4)$/i',
						'completed' => 'js:function (e,data) {
						$.each(data.files, function (index, file) {
						$("#Howto_video").val(\'\'+$("#Howto_video").val()+";"+file.name + \'\' );
						});
							}'),
		       ));

			   
	?>
	</div>

	</div><!-- form -->


