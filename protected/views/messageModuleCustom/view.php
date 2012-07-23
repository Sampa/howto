<?php $this->layout="ajax";?>
<?php $this->pageTitle=Yii::app()->name . ' - ' . MessageModule::t("Compose Message"); ?>
<?php $isIncomeMessage = $viewedMessage->receiver_id == Yii::app()->user->getId() ?>


<div class="row-fluid">

	<div class="span9" style="position:relative;">
		<?php $form = $this->beginWidget('BootActiveForm', array(
			'id'=>'message-delete-form',
			'enableAjaxValidation'=>true,
			'action' => $this->createUrl('delete/', array('id' => $viewedMessage->id))
		)); ?>
		<?php $this->endWidget(); ?>

		<table class="bordered-table zebra-striped">
			<tr>
				<th>
					<?php if ($isIncomeMessage): ?>
						From: <?= $viewedMessage->getSenderName() ?>
					<?php else: ?>
						To: <?= $viewedMessage->getReceiverName() ?>
					<?php endif; ?>
				</th>
				<th>
					<?= CHtml::encode($viewedMessage->subject) ?>
				</th>
				<th>
					<?= date(Yii::app()->getModule('message')->dateFormat,
						strtotime($viewedMessage->created_at)); ?>
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<?= CHtml::encode($viewedMessage->body); ?>
				</td>
			</tr>
		</table>

		<h2><?= MessageModule::t('Reply') ?></h2>

		<div class="form">
			<?php $form = $this->beginWidget('BootActiveForm', array(
				'id'=>'message-form',
				'enableAjaxValidation'=>true,
			)); ?>

			<?= $form->errorSummary($message, null, null, array('class' => 'alert-message block-message error')); ?>

			<div class="input">
				<?= $form->hiddenField($message,'receiver_id'); ?>
				<?= $form->error($message,'receiver_id'); ?>
			</div>
			<?= $form->labelEx($message,'subject'); ?>
			<div class="input">

				<?= $form->textField($message,'subject'); ?>
				<?= $form->error($message,'subject'); ?>
			</div>

			<?= $form->labelEx($message,'body'); ?>
			<div class="input">
				<?= $form->textArea($message,'body'); ?>
				<?= $form->error($message,'body'); ?>
			</div>


			<div class="buttons">
				<button class="btn btn-mini btn-primary"><i class="icon-white icon-repeat"></i> 
				<?= MessageModule::t("Reply") ?></button>
			
				<button class="btn btn-mini btn-danger"><i class="icon-white icon-remove"></i> <?= MessageModule::t("Delete") ?></button>

			</div>
		
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
	<script>
		$("#message-form").submit(function(event) {
		/* stop form from submitting normally */
		event.preventDefault(); 			
		/* get some values from elements on the page: */
		var receiver_id = $("#Message_receiver_id").val(),
			subject = $("#Message_subject").val(),
			body =  $("#Message_body").val(),
			url = '/message/view/reply';
		jQuery.post(url, {receiver_id: receiver_id, subject:subject,body:body }, function(data) {
				alert(data.message);
			},'json' );
			return false;
		});
	</script>