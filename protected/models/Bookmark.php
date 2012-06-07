<?php

/**
 * This is the model class for table "{{bookmark}}".
 *
 * The followings are the available columns in table '{{bookmark}}':
 * @property integer $user_id
 * @property integer $howto_id
 */
class Bookmark extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bookmark the static model class
	 */
	public $howto_title;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bookmark}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, howto_id howto_title', 'required'),
			array('user_id, howto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, howto_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function getBookmarks($user_id)
	{
		$bookmarks = Bookmark::findAllByAttributes( array('user_id'=>$user_id) );
		if ( !$bookmarks == null )
		{	
			$links = array();
			foreach ( $bookmarks as $bookmark )
			{
				$links[] = Howto::model()->getLink($bookmark->howto_id);
			
			}
		 return $links;
		}
		return false;
	
	}
	

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'howto' => array( self::BELONGS_TO , 'Howto', 'howto_id' ),
		'user'=>array( self::BELONGS_TO,'User','user_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'howto_id' => 'Howto',
			'howto_title'=>'Howto title',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('user_id', Yii::app()->user->id);
		$criteria->compare('howto_title',$this->howto_title);
		$criteria->compare('howto_id',$this->howto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}