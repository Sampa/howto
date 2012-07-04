<?php

class Comment extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_comment':
	 * @var integer $id
	 * @var string $content
	 * @var integer $status
	 * @var integer $create_time
	 * @var string $author
	 * @var string $email
	 * @var string $url
	 * @var integer $howto_id
	 */
	const STATUS_PENDING = 1;
	const STATUS_APPROVED = 2;
	public $response_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model( $className = __CLASS__ )
	{
		return parent::model( $className );
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, author', 'required'),
			array('author, email, url', 'length', 'max'=>128),
			array('email','email'),
			array('url','url'),
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
			'howto' => array( self::BELONGS_TO , 'Howto', 'howto_id' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'content' => 'Comment',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'author' => 'Name',
			'email' => 'Email',
			'url' => 'Website',
			'howto_id' => 'Howto',
		);
	}

	/**
	 * Approves a comment.
	 */
	public function approve()
	{
		$this->status = Comment::STATUS_APPROVED;
		$this->update( array( 'status' ) );
	}

	/**
	 * @param howto the howto that this comment belongs to. If null, the method
	 * will query for the howto.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl( $howto = null )
	{
		if ( $howto === null )
			$howto = $this->howto;
		return $howto->url . '#c' . $this->id;
	}

	/**
	 * @return string the hyperlink display for the current comment's author
	 */
	public function getAuthor()
	{
			$user = User::model()->findByPk($this->author);
			return $user;

	}

	/**
	 * @return integer the number of comments that are pending approval
	 */
	public function getPendingCommentCount()
	{
		return $this->count( 'status=' . self::STATUS_PENDING );
	}

	/**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public function findRecentComments( $limit=10 )
	{
		return $this->with( 'howto' )->findAll( 
			array(
				'condition'=>'t.status=' . self::STATUS_APPROVED,
				'order'=>'t.create_time DESC',
				'limit'=>$limit,
			));
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function afterSave()
	{
			$howto = Howto::model()->findByPk($this->howto_id);
			$title = $howto->title;
			$title = CHtml::link('Commented on '.$title , array('/howto/' . $this->howto_id . '/' . $title ) );
			$content = substr($this->content,0,160);
			$content .= "...";
			Action::newAction($content,$title);

	}
	protected function beforeSave()
	{
		if ( parent::beforeSave() )
		{
			if ( !Yii::app()->user->isGuest && $this->author == '' ){
				$this->author = Yii::app()->user->name;
				$this->status = 2;
			
			}
			if ( $this->isNewRecord )
				$this->create_time = time();
			return true;
		}
		else
			return false;
	}
}