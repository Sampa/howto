<!--
 * Ajax Crud Administration Form
 * Slide *
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 -->

<div id="slide_form_con" class="client-val-form">
    <?php if ($model->isNewRecord) : ?>    
	<h3 id="create_header">Create New Slide</h3>
    <?php  elseif (!$model->isNewRecord):  ?>    
	<h3 id="update_header">Update Slide 
	<?php  echo $model->id;  ?>  </h3>
    <?php   endif;  ?>
    <?php      $val_error_msg = 'Error.Slide was not saved.';
    $val_success_message = ($model->isNewRecord) ?
            'Slide was created successfuly.' :
            'Slide  was updated successfuly.';
  ?>

    <div id="success-note" class="notification success png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_success_message;  ?>        </div>
    </div>

    <div id="error-note" class="notification errorshow png_bg"
         style="display:none;">
        <a href="#" class="close"><img
                src="<?php echo Yii::app()->request->baseUrl.'/js_plugins/ajaxform/images/icons/cross_grey_small.png';  ?>"
                title="Close this notification" alt="close"/></a>
        <div>
            <?php   echo $val_error_msg;  ?>        </div>
    </div>

    <div id="ajax-form"  class='form'>
<?php   $formId='slide-form';
   $actionUrl = ($model->isNewRecord)?CController::createUrl('slide/ajax_create')
                                                                 :CController::createUrl('slide/ajax_update');

	$js_afterValidate = null;
    $form=$this->beginWidget('BootActiveForm', array(
     'id'=>'slide-form',
      'htmlOptions' => array('enctype' => 'multipart/form-data'),
         'action' => $actionUrl,
     'enableAjaxValidation'=>false,
      'enableClientValidation'=>false,
     'focus'=>array($model,'name'),
     'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
     'clientOptions'=>array('validateOnSubmit'=>true,
                                        'validateOnType'=>false,
                                        'afterValidate'=>$js_afterValidate,
                                        'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidate' => 'js:function(form,data,hasError){ $.js_afterValidate(form,data,hasError);  }',
                                         'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                                                                                                 $.js_afterValidateAttribute(form, attribute, data, hasError);
                                                                                                                            }'
                                                                             ),
));

     ?>
    <?php echo $form->errorSummary($model, '
    <div style="font-weight:bold">Please correct these errors:</div>
    ', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?>    <p class="note">Fields with <span class="required">*</span> are required.</p>


    <div class="row-fluid">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
        <span id="success-Slide_title"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'title'); ?>
    </div>
			<?php echo $form->labelEx($model, 'picture');?>
			<?php echo $form->fileField($model, 'picture');?>
		<span id="success-Slide_picture"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
			<?php echo $form->error($model, 'picture')?>

        <div class="row-fluid">
            <?php echo $form->labelEx($model,'text'); ?>
            <?php echo $form->textField($model,'text',array('size'=>60,'maxlength'=>255)); ?>
        <span id="success-Slide_text"
              class="hid input-notification-success  success png_bg right"></span>
        <div>
            <small></small>
        </div>
            <?php echo $form->error($model,'text'); ?>
    </div>
	
    <div class="row-fluid">
	<?php 
	echo $form->hiddenField($model,'howto_id',array('value'=>$howto) ); ?>
    </div>

    
    <input type="hidden" name="YII_CSRF_TOKEN"
           value="<?php echo Yii::app()->request->csrfToken; ?>"/>

    <?php  if (!$model->isNewRecord): ?>    <input type="hidden" name="update_id"
           value=" <?php echo $model->id; ?>"/>
    <?php endif; ?>
    <div class="row-fluid buttons">
        <?php   echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save',array('class' =>
        'btn btn-primary align-right')); ?>    </div>

  <?php  $this->endWidget(); ?></div>
    <!-- form -->

</div>
<script type="text/javascript">

    //Close button:

    $(".close").click(
            function () {
                $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                    $(this).slideUp(600);
                });
                return false;
            }
    );


</script>


