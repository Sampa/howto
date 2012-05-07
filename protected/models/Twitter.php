<?php

/**
 * This is the model class for table "{{twitter}}".
 *
 * The followings are the available columns in table '{{twitter}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $consumer_key
 * @property string $consumer_secret
 */
class Twitter extends Model
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Twitter the static model class
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
		return '{{twitter}}';
	}
public function post_tweet($tweet_text,$user) {
	$twitter = Twitter::model()->find('user_id='.$user);
  // Use Matt Harris' OAuth library to make the connection
  // This lives at: https://github.com/themattharris/tmhOAuth
  require_once('/oauth/tmhOAuth.php');
      
  // Set the authorization values
  // In keeping with the OAuth tradition of maximum confusion, 
  // the names of some of these values are different from the Twitter Dev interface
  // user_token is called Access Token on the Dev site
  // user_secret is called Access Token Secret on the Dev site
  // The values here have asterisks to hide the true contents 
  // You need to use the actual values from Twitter
  $connection = new tmhOAuth(array(
    'consumer_key' => $twitter->consumer_key,
    'consumer_secret' =>$twitter->consumer_secret,
    'user_token' => '105101246-9WNRVpMZYHyu701PHzr4aQB3fhTuPrdR7ZenCPIU',
    'user_secret' => 'CCe0hJ6MKtxqF8fjnvGuVJXGGfCmQznV5BKbLAMRQZM',
  )); 
  
  // Make the API call
  $connection->request('POST', 
    $connection->url('1/statuses/update'), 
    array('status' => $tweet_text));
  
  return $connection->response['code'];
}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, consumer_key, consumer_secret', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('consumer_key, consumer_secret', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, consumer_key, consumer_secret', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'consumer_key' => 'Consumer Key',
			'consumer_secret' => 'Consumer Secret',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('consumer_key',$this->consumer_key,true);
		$criteria->compare('consumer_secret',$this->consumer_secret,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}