<div id="left" style="float:left;" class="span4">

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

	
	
<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'avatar',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	
	<?php echo $form->hiddenField($model,'id', array( 'value'=>$model->id ) );?>
	
	<div class="row-fluid">
		<h4>Username</h4>
		<?php echo $form->textField($model,'username',
			array( 'size'=>60,'maxlength'=>128 ) ); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	

	<div class="row-fluid">
		<h4>Password
		</h4>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128,'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row-fluid">
		<h4>Repeat password</h4>
		<?php echo $form->passwordField($model,'password2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>
	
	
	<div class="row-fluid">
		<h4>Email
		</h4>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row-fluid buttons">
	<?php
		echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Save',
			array('class'=>'btn btn-mini btn-success', 'type'=>'submit') ); 
	?>
	</div>


<?php $this->endWidget(); ?>
</div><!-- //left -->





<div id="middle" class="span4" style="float:left;">
<?php if ( !$model->isNewRecord ): ?>
	
	<div id="avatar_upload" style="float:left;">
	 <h4> Upload an avatar </h4>
<?php 

	$XUpload = new XUploadForm;
	$this->widget('xupload.XUpload', 
			array(
					'url' => Yii::app()->createUrl("file/upload", 
					array("parent_id" =>User::USER_DIR . Yii::app()->user->id,'rename'=>rand(11111,99999999) ) ),
						'type'=>'avatar',
						'model' => $XUpload,
						'attribute' => 'file',
						'multiple'=>false,
						'options'=>array(
						'completed' => 'js:function (e,data) {
						var filename = data.files[\'0\'][\'name\'];
						showPic(filename);
						}'),
		       ));

			   
?>

	</div>
<div id="avatar"></div>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#User_password").val('');
	
	});
		function showPic(filename){
			var img = '<img src="<?=User::USER_DIR . Yii::app()->user->id;?>/'+filename+'" alt=""/>';
			$("#avatar").html(img);
			$("#User_avatar").val(filename);
		}
	</script>
	<?php endif;?>

</div>
