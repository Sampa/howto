<?php

class BadgerModule extends CWebModule
{
      private $_version = '1.0-beta';

      public $cacheSec = 3600; // 1hour
      public $install = false;
      public $dropBeforeInstall = false;
      public $userTable = 'user';
      public $layout = '//layouts/main';

      private $_assetsUrl;

      # Prepare
      # =====================================================================
      public function init()
      {
            // import the module-level models and components
            $this->setImport(array(
                  'badger.models.*',
                  'badger.components.*',
            ));

            # Check if need to drop tables before
            # ---------------------------------------------------------------------
            if( $this->dropBeforeInstall === true ) {
                  $this->dropTables();
            }

            # Check if need to install database
            # ---------------------------------------------------------------------
            if( $this->install === true ) {
                  $this->createTables();
                  $this->moveRequiredFiles();
                  $this->flushAssets();
            }


            # Publish assets
            # ---------------------------------------------------------------------
            $this->_assetsUrl = Yii::app()->assetManager->publish( Yii::getPathOfAlias('badger.assets') );

            # Register scripts/css
            # ---------------------------------------------------------------------
            $cs = Yii::app()->getClientScript()
                        ->registerCssFile( $this->_assetsUrl.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'badger.css' );


      }

      # Clear assets folder
      # =====================================================================
      public function flushAssets() {
            $assetsPath = Yii::app()->assetManager->getPublishedPath( Yii::getPathOfAlias('badger.assets') );
            shell_exec('rm -rf '.$assetsPath);
      }

      # Drop badger table
      # =====================================================================
      private function dropTables() {
            $cmd = Yii::app()->db->createCommand();

            try { $cmd->dropIndex('_user_badge_user_id_fkey','_user_badge'); }
            catch(Exception $e) {
                  //echo 'Could\'nt drop "'.__CLASS__.'" indexes..';
            }

            try { $cmd->dropIndex('_user_badge_badge_id_fkey','_user_badge'); }
            catch(Exception $e) {
                  //echo 'Could\'nt drop "'.__CLASS__.'" indexes..';
            }

            try { $cmd->dropIndex('badge_slug_ukey','badge'); }
            catch(Exception $e) {
                  //echo 'Could\'nt drop "'.__CLASS__.'" indexes..';
            }

            $cmd = Yii::app()->db->createCommand();

            try { $cmd->dropTable('_user_badge'); }
            catch(Exception $e) {
                  //echo 'Could\'nt drop "'.__CLASS__.'" tables..';
            }

            try { $cmd->dropTable('badge'); }
            catch(Exception $e) {
                  //echo 'Could\'nt drop "'.__CLASS__.'" tables..';
            }
      }

      # Check files that required, bu cant be overrided on upgrade
      # =====================================================================
      public function moveRequiredFiles() {
            $modulePath = dirname(__FILE__).DIRECTORY_SEPARATOR;
            $suffix = '.original';

            # These files are "upgrade-proof" (not in repository, jus their copies)
            # Will not be overwriten by new version
            # =====================================================================
            $requiredFilePathArr = array(
                  'badgeModel' => $modulePath.'models'.DIRECTORY_SEPARATOR.'Badge.php',
                  'badgeController' => $modulePath.'controllers'.DIRECTORY_SEPARATOR.'BadgeController.php',
                  'badgeCssFile' => $modulePath.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'badger.css',
                  'badgeView_List' => $modulePath.'views'.DIRECTORY_SEPARATOR.'badge'.DIRECTORY_SEPARATOR.'_list.php',
                  'badgeViewList' => $modulePath.'views'.DIRECTORY_SEPARATOR.'badge'.DIRECTORY_SEPARATOR.'list.php',
                  'badgeViewMy' => $modulePath.'views'.DIRECTORY_SEPARATOR.'badge'.DIRECTORY_SEPARATOR.'my.php',
            );

            foreach($requiredFilePathArr as $targetPath) {
                  $targetPath = $targetPath;
                  $sourcePath = $targetPath.$suffix;

                  $targetExists = file_exists($targetPath);
                  $sourceExists = file_exists($sourcePath);

                  // Both files missing. BAD!
                  if( !$targetExists && !$sourceExists ) {
                        throw new Exception('Required files missing ('.$targetPath.')');
                  }

                  // Target missing: not so bad
                  // Copy original files to their required destination
                  if(! $targetExists) {
                        copy( $sourcePath, $targetPath);
                        if(! file_exists($targetPath) ) {
                              shell_exec('cp '.$sourcePath.' '.$targetPath.'');
                        }
                  }
            }
      }

      # Create tables
      # You can find script under badger/res/*.sql (ASCII file encoding)
      # =====================================================================
      private function createTables() {
            $resourcePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'res'.DIRECTORY_SEPARATOR;

            # Badge table
            # ---------------------------------------------------------------------
            $cmd = Yii::app()->db->createCommand();
            $cmd->createTable('badge',array(
                  'id' => 'pk',
                  'name' => 'VARCHAR(64) NOT NULL',
                  'slug' => 'VARCHAR(32) NOT NULL',
                  'desc' => 'text',
                  'exp' => 'integer DEFAULT 0',
                  'active' => 'boolean DEFAULT TRUE',
                  'user_count' => 'integer DEFAULT 0',
                  't_insert' => 'datetime',
                  't_update' => 'datetime',
            ));
            $cmd->createIndex('badge_slug_ukey', 'badge', 'slug', $unique=true);

            # Link table: User <-> Badge
            # ---------------------------------------------------------------------
            $cmd = Yii::app()->db->createCommand( );
            $cmd->createTable('_user_badge',array(
                  'user_id' => 'integer',
                  'badge_id' => 'integer',
                  'PRIMARY KEY (user_id, badge_id)'
            ));

            #TODO: bug, cant add foreign key to user table
            //$cmd->addForeignKey('_user_badge_user_id_fkey',
            //                        '_user_badge', 'user_id',
            //                        'user', 'id'
            //);
            $cmd->addForeignKey('_user_badge_badge_id_fkey',
                                    '_user_badge', 'badge_id',
                                    'badge', 'id'
            );

            # Insert default badges
            # ---------------------------------------------------------------------
            $cmd = Yii::app()->db->createCommand();

            $cmd->insert('badge',array(
                  'name' => 'First login',
                  'slug' => 'login-first',
                  'desc' => 'Logged for the first time',
            ));
            $cmd->insert('badge',array(
                  'name' => 'List viewer',
                  'slug' => 'list-my',
                  'desc' => 'View my badges',
            ));


      }

      # Get published assets url
      # =====================================================================
      public function getAssetsUrl() {
            return $this->_assetsUrl;
      }

      # Before action
      # =====================================================================
      public function beforeControllerAction($controller, $action)
      {
            if(parent::beforeControllerAction($controller, $action))
            {

                  $controller->layout = $this->layout;
                  // this method is called before any module controller action is performed
                  // you may place customized code here
                  return true;
            }
            else
                  return false;
      }
}
