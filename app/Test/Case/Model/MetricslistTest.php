<?php
App::uses('Metricslist', 'Model');

/**
 * Metricslist Test Case
 *
 */
class MetricslistTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.metricslist'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Metricslist = ClassRegistry::init('Metricslist');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Metricslist);

		parent::tearDown();
	}

}
