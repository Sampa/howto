<?php

if(! $badges) {
      echo '<div class="alert alert-error">'.Yii::t('badgerModule.Site','No badges found').'</div>';
      return false;
}

# List of badges
# =====================================================================

echo '<div class="badges">';
      foreach($badges as $Badge) {
            echo '<span class="badge">'
                  .CHtml::image( $Badge->getImageUrl() , $Badge->slug, array('style' => 'float:right;margin-left:10px;'))
                  .'<b class="name">'.Yii::t('badgerModule.Site',$Badge->name).'</b>'
                  .'&nbsp;<abbr class="count" title="'.Yii::t('badgerModule.Site','{n} user have it|{n} users have it',$Badge->user_count).'">'.$Badge->user_count.'</abbr>'
                  .'<div class="description">'.$Badge->desc.'</div>'
            .'</span>';
      }

echo '<br class="clear-both" /></div>';


//Badge::checkAndGiveOne( Badge::BADGE_COMMENT_FIRST );
//Badge::checkAndGiveGroup( 'comment' );
?>

<h3 style="margin-top:50px;">Place this code after user successful login and he will get badge</h3>
<pre>
$Badge = new Badge;
// add custom event after giving badge to user
$Badge->onSuccess = function($event){
    echo 'Badge '.$event->sender->name.' given'; // $event->sender->getImageUrl();
    Yii::app()->end();
    // or setFlash message here to notify user
};
$Badge->checkAndGiveGroup('Login');
</pre>
