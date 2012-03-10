<?php

class PostTest extends CDbTestCase
{
	/**
	 * We use both 'Howto' and 'Comment' fixtures.
	 * @see CWebTestCase::fixtures
	 */
	public $fixtures=array(
		'posts'=>'Howto',
		'comments'=>'Comment',
	);

	public function testSave()
	{
		// write code here to test post saving method
	}
}