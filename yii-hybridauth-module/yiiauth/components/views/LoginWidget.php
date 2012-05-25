    <h3>Or use anohter service</h3>
     <?php $url = Yii::app()->module->hybridauth->basePath();?>
	<?=CHtml::link('<img src="'.$url.'buttons/facebook_'.$icon.'.png" />',array('/user/sociallogin/provider/facebook'));?>
	<?=CHtml::link('<img src="/yii-hybridAuth/buttons/twitter_'.$icon.'.png" />',array('/user/sociallogin/provider/twitter'));?>
	<?=CHtml::link('<img src="/yii-hybridAuth/buttons/openid_'.$icon.'.png" />',array('/user/sociallogin/provider/openid'));?>
	<?=CHtml::link('<img src="/yii-hybridAuth/buttons/linkedin_'.$icon.'.png" />',array('/user/sociallogin/provider/linkedin'));?>
   