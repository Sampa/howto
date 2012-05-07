<?php
$this->breadcrumbs=array(
	'Twitter',
);

?>

<h1>Twitter</h1>
<?php 
$this->pageTitle=Yii::app()->name . ' - Attach to Twitter';
?>
 
<? if ( ! Yii::app()->twitter->isAuthorized ) { ?>
<h1>Link your Twitter Account!</h1>
 
<div class="yiiForm">
    <?php echo CHtml::form(); ?>
        <div class="simple">
            Click the button below to be taken to <a href="http://www.twitter.com/" target=_blank>Twitter</a> to link your account.
            <br />
            <br />
            <br />
            <a href="<?=Yii::app()->twitter->getAuthorizeUrl()?>"><img src="/images/twitter_sign.png" border="0" alt="Sign in with Twitter" /></a>
        </div>
    </form>
</div><!-- yiiForm -->
<? } else { ?>
<h1>Linked with Twitter!</h1>
 
<div class="yiiForm">
    <?php echo CHtml::form(); ?>
        <div class="simple">
            Your account is currently linked to your Twitter account <b><?= Yii::app()->twitter->screenName ?>.
            <br />
            <br />
            <br />
        </div>
    </form>
</div><!-- yiiForm -->
<? } ?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
