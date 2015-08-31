<?php
/**
 * BAase exception class for the roman numerals plugin
 */
class RomanNumeralException extends CakeException {

}

/**
 * Exception thrown when there is a problem with the given roman numeral
 */
class InvalidRomanNumeralException extends RomanNumeralException {

/**
 * Exception message
 */
	protected $_messageTemplate = 'Invalid roman numeral provided [%s], should be in the form IVXLCDM';

/**
 * Constructor
 *
 * @param string $input the provided input that is not correct
 * @param int $code The code of the error, is also the HTTP status code for the error.
 */
	public function __construct($input, $code = 422) {
		parent::__construct(__d('roman', $this->_messageTemplate, $input), $code);
	}
}

/**
 * Exception thrown when there is a problem with the given roman numeral
 */
class RomanNumeralTooLargeException extends RomanNumeralException {

/**
 * Exception message
 */
	protected $_messageTemplate = 'The roman numeral provided is too large [%s]';

/**
 * Constructor
 *
 * @param string $input the provided input that is not correct
 * @param int $code The code of the error, is also the HTTP status code for the error.
 */
	public function __construct($input, $code = 413) {
		parent::__construct(__d('roman', $this->_messageTemplate, $input), $code);
	}
}

/**
 * Exception thrown when an invalid integer is provided
 */
class InvalidIntegerException extends RomanNumeralException {

/**
 * Exception message
 */
	protected $_messageTemplate = 'Invalid integer provided [%s], should be integer greater than zero';

/**
 * Constructor
 *
 * @param string $input the provided input that is not correct
 * @param int $code The code of the error, is also the HTTP status code for the error.
 */
	public function __construct($input, $code = 422) {
		parent::__construct(__d('roman', $this->_messageTemplate, $input), $code);
	}
}

/**
 * Exception thrown when there is a problem with the given roman numeral
 */
class IntegerTooLargeException extends RomanNumeralException {

/**
 * Exception message
 */
	protected $_messageTemplate = 'The integer provided is too large [%s]';

/**
 * Constructor
 *
 * @param string $input the provided input that is not correct
 * @param int $code The code of the error, is also the HTTP status code for the error.
 */
	public function __construct($input, $code = 413) {
		parent::__construct(__d('roman', $this->_messageTemplate, $input), $code);
	}
}