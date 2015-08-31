<?php
App::uses('RomanNumeralInterface', 'Roman.Lib');

/**
 * Lib for converting roman numerals to integers
 *
 * @package Roman.Lib
 */
class RomanLib implements RomanNumeralInterface {

/**
 * Minimum value a roman numeral can define
 */
	const MIN_ROMAN = 1;

/**
 * Maximum value a roman numeral can define
 */
	const MAX_ROMAN = 3999;

/**
 * Map of possible values
 */
	protected $_map = array(
		'M' => 1000,
		'CM' => 900,
		'D' => 500,
		'CD' => 400,
		'C' => 100,
		'XC' => 90,
		'L' => 50,
		'XL' => 40,
		'X' => 10,
		'IX' => 9,
		'V' => 5,
		'IV' => 4,
		'I' => 1,
	);

/**
 * Check the given value is an actual roman numeral
 */
	public function validateRoman($roman) {
		$roman = strtoupper((string)$roman);
		preg_match_all('/[IVXLCDM]+/', $roman, $matches);
		return !empty($matches[0][0]) && $matches[0][0] == $roman;
	}

/**
 * Check the given value is an integer
 */
	public function validateInteger($integer) {
		return is_numeric($integer) && (int)$integer == $integer;
	}

	public function validateInRange($integer) {
		return $integer >= self::MIN_ROMAN && $integer <= self::MAX_ROMAN;
	}

/**
 * Convert from the given roman to integer
 *
 * First tries for an exact match in the map to skip some processing.
 * 
 * @param string $roman the value in roman numerals
 *
 * @throws InvalidRomanNumeralException if the provided input is not a valid roman numeral
 * @throws RomanNumeralTooLargeException if the given input is too large
 *
 * @return int
 */
	function parse($roman) {
		if (is_string($roman)) {
			$roman = strtoupper((string)$roman);
		}
		$romanOriginal = $roman;
		if (!$this->validateRoman($romanOriginal)) {
			throw new InvalidRomanNumeralException($romanOriginal);
		}

		$return = 0;
		foreach (array_keys($this->_romanMap()) as $romanKey) {
			$return += $this->parseSingle($roman, $romanKey);
		}

		if ($return > self::MAX_ROMAN) {
			throw new RomanNumeralTooLargeException($romanOriginal);
		}

		return $return;
	}

/**
 * Parse the given roman numeral and find the corresponding value
 * 
 * @param string $roman the roman numeral being parsed
 * @param string $key the key of the roman numeral map currently being parsed.
 * 
 * @return int
 */
	public function parseSingle(&$roman, $key) {
		$return = $this->_romanLookup($roman);
		if ($return > 0) {
			$roman = '';
			return $return;
		}
		$return = 0;
		while (strpos($roman, $key) === 0) {
			$return += $this->_romanLookup($key);
			$roman = substr($roman, strlen($key));
		}
		return $return;
	}

/**
 * Convert a given integer to a roman numeral string
 *
 * @param int $integer the number being converted to roman numerals
 *
 * @throws InvalidIntegerException if the provided input is not a valid roman numeral
 * @throws IntegerTooLargeException if the given input is too large
 *
 * @return string
 */
	public function generate($integer) {
		if (!$this->validateInteger($integer)) {
			throw new InvalidIntegerException($integer);
		}

		if (!$this->validateInRange($integer)) {
			throw new IntegerTooLargeException($integer);
		}

		$return = '';
		foreach (array_keys($this->_romanMap()) as $romanKey) {
			$return .= $this->generateSingle($integer, $romanKey);
		}

		return $return;
	}

/**
 * Calculate the roman value for the specified key of the map
 *
 * @param int $integer the integer being converted to roman numerals
 * @param string $key the key from the roman numeral map
 *
 * @return string
 */
	public function generateSingle(&$integer, $key) {
		$number = $this->_romanLookup($key);
		$matches = intval($integer / $number); 
        $return = str_repeat($key, $matches); 
        $integer = $integer % $number; 

        return $return;
	}

/**
 * Get a value from the roman numeral map, defaults to 0
 *
 * @param string $key the key to look up
 *
 * @return int
 */
	protected function _romanLookup($key) {
		if (empty($this->_romanMap()[$key])) {
			return 0;
		}
		return $this->_romanMap()[$key];
	}

	protected function _romanMap() {
		return $this->_map;
	}

}