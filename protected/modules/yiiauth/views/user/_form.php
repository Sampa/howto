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
			array('class'=>'btn btn-mini btn-success', 'type'=>'submit','id'=>'save_button') ); 
	?>
	</div>
	
	
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />

<?php $this->endWidget(); ?>

</div><!-- //left -->


<div id="middle" class="span8" style="float:left;">
<?php if ( !$model->isNewRecord ): ?>
	
	<div id="avatar_upload" style="float:left;">
	 <h4> Upload an avatar </h4>
	<script type="text/javascript">
	function showPic(filename){
	var img = '<img src="<?=User::USER_DIR . Yii::app()->user->id;?>/'+filename+'" id="target" alt=""/>';
	var cropped = '<img src="<?=User::USER_DIR . Yii::app()->user->id;?>/'+filename+'" id="preview" class="jcrop-preview" alt=""/>';
			$(".cropinfo").show();
			$("#avatar").html(img);
			$("#preview_div").html(cropped);
			$("#User_avatar").val(filename);
			initCrop();
		}

	</script>
<?php 

	$XUpload = new XUploadForm;
	$this->widget('xupload.XUpload', 
			array(
					'url' => Yii::app()->createUrl("file/upload", 
					array("parent_id" =>User::USER_DIR . Yii::app()->user->id) ),
						'type'=>'avatar',
						'model' => $XUpload,
						'attribute' => 'file',
						'multiple'=>false,
						'options'=>array(
						'autoUpload'=>true,
						'completed' => 'js:function (e,data) {
						var filename = data.files[\'0\'][\'name\'];
						showPic(filename);
						}'),
		       ));

			   
?>
<div style=" float:left; ">
					<h4 class="cropinfo" style="display:none;">Please select an area of the image</h4>
					<div id="avatar" style=" float:left;"></div>
			</div>
	<div class="" style=" position:absolute;left:60px; top:380px; z-index: 100; min-width:250px; min-height:250px; max-width:260px;"></>
				<h4 class="cropinfo" style="display:none;">This is what your avatar will look like</h4>
				<div id="preview_div" style="width:250px;height:250px;overflow:hidden;"></div>
	</div>
			
		

	</div>
	
	
	
<?php 
Yii::app() -> clientScript -> registerCssFile('/css/jquery.jcrop.css');
      Yii::app() -> clientScript -> registerScriptFile("/js/jquery.jcrop.min.js");
	  Yii::app() -> clientScript -> registerScriptFile("/js/jquery.color.js");
?>
<script type="text/javascript">
function initCrop(){
  // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;

      $('#target').Jcrop({
        onChange: updatePreview,
        onSelect: updatePreview,
        aspectRatio: 1,
		minSize: [ 250, 250 ],
        maxSize: [ 250, 250 ],
		allowResize: false,

      },function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
      });
      function updatePreview(c)
      {
		
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);

        if (parseInt(c.w) > 0)
        {
          var rx = 250 / c.w;
          var ry = 250 / c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
      };
	  };
	 $("#save_button").click(
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	});
	$(document).ready(function(){
		$("#User_password").val('');
	});

  </script>


	
	
	
	<?php endif;?>

</div>
