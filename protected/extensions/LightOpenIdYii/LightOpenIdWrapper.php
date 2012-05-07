<?php

require_once 'lightopenid'.DIRECTORY_SEPARATOR.'openid.php';

class LightOpenIDWrapper extends CApplicationComponent {

	private $__lightopenid;

	public function init() {
		parent::init();
		$this->__lightopenid = new LightOpenID(Yii::app()->createAbsoluteUrl('//user'));
	}

	public function __call($name, $arguments = array()) {
		if(method_exists($this->__lightopenid, $name))
			return call_user_func_array(array($this->__lightopenid, $name), $arguments);
	}

	public function __get($name) {
		return $this->__lightopenid->$name;
	}

	public function __set($name, $value) {
		return $this->__lightopenid->$name = $value;
	}
}