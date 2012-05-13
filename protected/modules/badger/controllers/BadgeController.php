<?php

class BadgeController extends Controller
{

      public function filters()
      {
            return array(
                  'accessControl', // perform access control for CRUD operations
            );
      }

      public function accessRules()
      {
            return array(
                  array('allow',
                    'actions'=>array(
                        'list',
                    ),
                    'users'=>array('*'),
                  ),

                  array('allow',
                    'actions'=>array(
                        'my',
                    ),
                    'users'=>array('@'),
                  ),

                  array('deny','users'=>array('*')), //all actions deny from all users by default
            );
      }


      # Show available badges
      # =====================================================================
      public function actionList()
      {
            $this->pageTitle = Yii::t('badgerModule.Site','All badges');

            $badges = Badge::model()->findAll();

            $this->render('list',array(
                  'badges' => $badges,
            ));
      }


      # Show currently logged user badges
      # =====================================================================
      public function actionMy()
      {
            $this->pageTitle = Yii::t('badgerModule.Site','My badges');

            $Badge = new Badge;
            $Badge->checkAndGiveOne( Badge::BADGE_LIST_MY );

            $badges = Badge::model()->my()->findAll();
            user()->setState('badge_count', count($badges) ); //refresh badge count for user

            $this->render('my',array(
                  'badges' => $badges,
            ));
      }
}
