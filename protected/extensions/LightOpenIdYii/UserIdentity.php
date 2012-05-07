<?php

class UserIdentity extends CUserIdentity {

	const ERROR_CANCELLED=9;

	public $openid = array();
	private $id;

	public function __construct() {

	}

	public function authenticate() {

		if(isset($this->openid['openid_mode'])) {
			if($this->openid['openid_mode'] == 'cancel') {
				$this->errorCode = self::ERROR_CANCELLED;
			} elseif(Yii::app()->openid->validate()) {
				$this->errorCode = self::ERROR_NONE;
				$this->username = $this->openid['openid_ext1_value_contact_email'];

				// save/load user information from wherever and return the ID
				$this->id = User::syncWithDb($this->openid);

				Yii::app()->user->login($this);
			}
			return $this->errorCode;
		} else {
			return;
		}
	}

	public function getId() {
		return $this->id;
	}
}