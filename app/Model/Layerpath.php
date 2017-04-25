<?php
App::uses('AppModel', 'Model');
/**
 * Layerpath Model
 *
 * @property Layer $Layer
 */
class Layerpath extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Layer' => array(
			'className' => 'Layer',
			'foreignKey' => 'layer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
