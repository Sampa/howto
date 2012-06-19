<?php $this->layout ="ajax";?>

<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_styles') ?>
<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_flash') ?>

<div class="span12" style="float:left;">
		<div>
				<h2><?= MessageModule::t('New Message'); ?></h2>
			<?php $form = $this->beginWidget('BootActiveForm', array(
				'id'=>'message-form',
				'enableAjaxValidation'=>false,
			)); ?>

			<p class="note">
	<?= MessageModule::t('Fields with <span class="required">*</span> are required.'); ?>
			</p>

			<?= 
				$form->errorSummary($model, null, null, 
				array('class' => 'alert-message block-message error')); 
			?>

			<?= $form->labelEx($model,'receiver_id'); ?>
			<div class="input">
				<?= CHtml::textField('receiver', $receiverName) ?>
				<?= $form->hiddenField($model,'receiver_id'); ?>
				<?= $form->error($model,'receiver_id'); ?>
			</div>

			<?= $form->labelEx($model,'subject'); ?>
			<div class="input">
				<?= $form->textField($model,'subject',array('style'=>'max-width:90%;')); ?>
				<?= $form->error($model,'subject'); ?>
			</div>

			<?= $form->labelEx($model,'body'); ?>
			<div class="input">
				<?= $form->textArea($model,'body',array('style'=>'max-width:90%;')); ?>
				<?= $form->error($model,'body'); ?>
			</div>

			<div class="buttons">
				<button class="btn btn-mini btn-success">
					<i class="icon-envelope icon-white"></i>
					<?= MessageModule::t("Send") ?>
				</button>
			</div>

			<?php $this->endWidget(); ?>

		</div>
	</div>

<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_suggest'); ?>
