<?php
App::uses('Layerpath', 'Model');

/**
 * Layerpath Test Case
 *
 */
class LayerpathTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.layerpath',
		'app.layer'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Layerpath = ClassRegistry::init('Layerpath');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Layerpath);

		parent::tearDown();
	}

}
