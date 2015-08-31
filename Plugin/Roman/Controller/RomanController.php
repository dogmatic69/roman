<?php
App::uses('RomanLib', 'Roman.Lib');
App::uses('Xml', 'Utility');
/**
 * Roman controller
 *
 * @package Roman
 */

class RomanController extends RomanAppController {

/**
 * Disable the model
 */
	public $uses = false;

/**
 * action for converting between roman and integer
 */
	public function convert() {

	}

	public function to_integer($roman = null) {
		$this->layout = 'ajax';

		try {
			if (!empty($roman)) {
				$this->set(array(
					'status' => true,
					'roman' => $roman,
					'integer' => $this->_getInstance()->parse($roman),
					'_serialize' => array('roman', 'integer'),
				));
			}
		} catch (RomanNumeralException $e) {
			$this->set(array(
				'status' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				'_serialize' => array('status', 'message', 'code'),
			));
		}
		$this->render('output');
	}

	public function to_roman($integer = null) {		
		$this->layout = 'ajax';

		try {
			if (!empty($integer)) {
				$this->set(array(
					'status' => true,
					'roman' => $this->_getInstance()->generate($integer),
					'integer' => $integer,
					'_serialize' => array('roman', 'integer'),
				));
			}
		} catch (RomanNumeralException $e) {
			$this->set(array(
				'status' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				'_serialize' => array('status', 'message', 'code'),
			));
		}
		$this->render('output');
	}

	protected function _getInstance() {
		return new RomanLib();
	}
}