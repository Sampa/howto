<?php

/**
 * This is the model class for table "badge".
 *
 * The followings are the available columns in table 'badge':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $exp
 * @property boolean $active
 * @property string $t_insert
 * @property string $t_update
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class BadgeParent extends CActiveRecord
{

      /**
       * Returns the static model of the specified AR class.
       * @param string $className active record class name.
       * @return Badge the static model class
       */
      public static function model($className=__CLASS__)
      {
            return parent::model($className);
      }

      /**
       * @return string the associated database table name
       */
      public function tableName()
      {
            return 'badge';
      }
      public $sequenceName = 'badge_id_seq';

      public $success = false;

      /**
       * @return array validation rules for model attributes.
       */
      public function rules()
      {
            return array(
                  array('slug, required', 'required'),
                  array('slug', 'length', 'max'=>32),
                  array('slug', 'unique'),
                  array('slug', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-z_-]+)$/','message'=>'0-9, a-z, _, -'),
                  array('exp, user_count', 'numerical', 'integerOnly'=>true),
                  array('name', 'length', 'max'=>64),
                  array('active', 'boolean'),
                  array('t_insert, t_update', 'type', 'type' => 'datetime', 'datetimeFormat' => self::DATETIME_VALIDATION ),
                  array('desc', 'safe'),
            );
      }

      /**
       * @return array relational rules.
       */
      public function relations()
      {
            return array(
                  'users' => array(self::MANY_MANY, 'User', '_user_badge(badge_id, user_id)'),
            );
      }

      /**
       * @return array customized attribute labels (name=>label)
       */
      public function attributeLabels()
      {
            return array(
                  'id' => 'ID',
                  'name' => Yii::t('badgerModule.Site','Name'),
                  'slug' => Yii::t('badgerModule.Site','Slug'),
                  'desc' => Yii::t('badgerModule.Site','Description'),
                  'exp' => Yii::t('badgerModule.Site','Expierience'),
                  'active' => Yii::t('badgerModule.Site','Active'),
                  't_insert' => Yii::t('badgerModule.Site','Created'),
                  't_update' => Yii::t('badgerModule.Site','Updated'),
            );
      }

      # Event : onSuccess
      # ============================================================
      public function onSuccess($event){
            $Badge = $event->sender;
            $Badge->saveCounters(array('user_count' => 1));
            $this->raiseEvent('onSuccess', $event);
      }

      # After find translate
      # =====================================================================
      public function afterSave() {

            $this->name = Yii::t('badgerModule.Site', $this->name);
            $this->desc = Yii::t('badgerModule.Site', $this->desc);

            return parent::afterSave();
      }

    /*
        Get class constants by token.
        If you set constants with same prefix, like:
            MY_STATUS_1
            MY_STATUS_2
            MY_STATUS_3

        , you can get it by calling
        Class::getConstants('MY');
        or
        Class::getConstants('MY_STATUS');
    */
    public function getConstants($token,$objectClass) {
        $tokenLen = strlen($token);
        $reflection = new ReflectionClass($objectClass); //php built-in class for class metadata
        $allConstants = $reflection->getConstants(); //get class constants as array
        $tokenConstants = array(); //save only tooen-valid constants
        foreach($allConstants as $name => $val) {
            if(substr($name,0,$tokenLen) != $token) continue;
            $tokenConstants[ $name ] = $val;
        }
        //dbglog($tokenConstants,'tokenConstants');
        return $tokenConstants;
    }

      # Get badge image url
      # =====================================================================
      public function getImageUrl( $slug = null ) {
            if( $slug === null) {
                  $slug = $this->slug;
            }

            return Yii::app()->controller->module->getAssetsUrl().DIRECTORY_SEPARATOR
                        .'images'.DIRECTORY_SEPARATOR
                        .$slug.'.png';
      }

      # Get filtered user Id
      # =====================================================================
      static private function filterUserId( $userId = null ) {
            if( $userId === null && Yii::app()->user->isGuest ) {
                  // User not logged
                  return false;
            }
            else if(! Yii::app()->user->isGuest) {
                  // Get currently logged user id
                  $userId = Yii::app()->user->id;
            }

            return (int) $userId;
      }

      # Default scope
      # =====================================================================
      public function defaultScope() {
            return array('condition'=>'active=TRUE');
      }

      # My battles. Im owner
      # =====================================================================
      public function my() {
            $this->getDbCriteria()->mergeWith(array(
                  'condition' => $this->getTableAlias(false, false).'.id IN (SELECT badge_id FROM _user_badge WHERE user_id = :USER)',
                  'params' => array(':USER' => user()->id),
            ));

            return $this;
      }

      # By slug
      # =====================================================================
      public function slug( $badgeSlug ) {

            $this->getDbCriteria()->mergeWith(array(
                  'condition' => $this->getTableAlias(false, false).'.slug = :SLUG',
                  'params' => array(':SLUG' => $badgeSlug),
            ));

            return $this;
      }

      # Get active badges
      # =====================================================================
      static public function getAll() {
            //$cacheSec = Yii::app()->controller->module->cacheSec;
            //$badges = Badge::model()->cache( $cacheSec )->findAll();
			$badges = Badge::model()->findAll();

            return $badges;
      }

      # Get active badges as array with column pair
      # =====================================================================
      public static function getList($column1 = 'id', $column2 = 'slug') {
            $badges = self::getAll();
            $badgeList = CHtml::listData( $badges, $column1, $column2);
            return $badgeList;
      }

      # Get badge by id
      # =====================================================================
      public function getById( $id ) {
            $badges = self::getAll();
            if(! $badges ) { return false; }

            foreach($badges as $Badge) {
                  if($Badge->id == $id) {
                        return $Badge;
                  }
            }

            return false;
      }

      # Get badge by slug
      # =====================================================================
      public function getBySlug( $slug ) {
            $badges = self::getAll();
            if(! $badges ) { return false; }

            foreach($badges as $Badge) {
                  if($Badge->slug == $slug) {
                        return $Badge;
                  }
            }

            return false;
      }

      # Check if user already have badge
      # =====================================================================
      public static function have( $badgeSlug, $userId = null ) {
            $userId = self::filterUserId( $userId );

            // select return
            $haveBadge = Yii::app()->db->createCommand()
                ->select('COUNT(1)')
                ->from('_user_badge ub')
                ->join(BadgeParent::model()->tableName().' b', 'ub.badge_id = b.id')
                ->where('user_id = :USER AND slug = :BADGE_SLUG', array(':USER' => $userId, ':BADGE_SLUG' => $badgeSlug))
                ->queryScalar();

            return $haveBadge;
      }

      # Check if user already have badge
      # =====================================================================
      public function give( $slug, $userId = null ) {
            $userId = self::filterUserId( $userId );
            if(! $userId) {
                  return false;
            }

            // check if badge exists
            $Badge = $this->getBySlug($slug);
            if(! $Badge) {
                  return false;
            }

            // assign badge to user
            $sql = 'INSERT INTO _user_badge(user_id,badge_id) VALUES(:USER,:BADGE);';
            $params = array();
            $params[':USER'] = $userId;
            $params[':BADGE'] = $Badge->id;
            $command = Yii::app()->db->createCommand($sql);
            if(! $command->execute($params) ) {
                  return false;
            }

            // success

            if( $this->hasEvent('onSuccess') ) {
                  // To enable event assign event before giving badge to user
                  // Put commented code below somewhere you are giving badge to user
                  /*
                        $Badge = new Badge;
                        $Badge->onSuccess = array( $object, 'callbackFunction');
                        $badgeIdArr = $Badge->checkAndGiveGroup( get_class($this) );
                  */


                  $Badge = $this->getBySlug( $slug );
                  $event = new CModelEvent( $Badge );
                  $this->onSuccess($event);
            }

            return true;
      }

      # Check and give
      # =====================================================================
      public function checkAndGiveOne( $slug, $userId = null) {
            $userId = self::filterUserId( $userId );
            if(! $userId) {
                  return false;
            }

            if( self::have($slug,$userId) ) {
                  return false;
            }

            $this->success = false;

            # This function you are editing in your Badge class
            # ------------------------------------------------------------
            $this->check( $slug );

            // raise event
            if( $this->success ) {
                  return $this->give($slug,$userId);
            }

            return false;
      }

      # user must define it in Badge class
      # ============================================================
      public function check( $slug ) {

      }

      # Check one group (check one group for all its badges)
      # =====================================================================
      public function checkAndGiveGroup( $group, $userId = null) {
            $userId = self::filterUserId( $userId );
            if(! $userId) {
                  return false;
            }

            $group = strtoupper( $group );
            $badgesConstantsArr = self::getConstants( 'BADGE_'.$group.'_', 'Badge' );
            if(! $badgesConstantsArr) {
                  return false;
            }

            // prepare
            $badgesArr = self::getList();
            $badgesSlugIdArr = array_flip( $badgesArr );

            // select return
            $existingBadges = Yii::app()->db->createCommand()
                ->select('badge_id')
                ->from('_user_badge ub')
                ->where('user_id = :USER', array(':USER' => $userId))
                ->queryAll();
            $existingBadges = CHtml::listData($existingBadges,'badge_id','badge_id');

            $badgesGiveIdArr = array();
            foreach($badgesConstantsArr as $badgeSlug) {
                  $tmpBadgeId = $badgesSlugIdArr[$badgeSlug];
                  // skip tha is already gaven
                  if(! in_array($tmpBadgeId, $existingBadges) ) {
                        if( $this->checkAndGiveOne( $badgeSlug, $userId) ) {
                              $badgesGiveIdArr[$tmpBadgeId] = $badgeSlug;
                        }
                  }
            }

            return $badgesGiveIdArr;
      }


}
