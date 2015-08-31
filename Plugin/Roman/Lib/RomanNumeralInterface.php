<?php
/**
 * Conversion interface for roman numerals
 *
 * @package Roman
 */
interface RomanNumeralInterface {

/**
 * Convert from integer to roman numeral
 *
 * @param int $integer the integer value to convert to roman numeral
 *
 * @return string
 */
	public function generate($integer);

/**
 * Convert from roman numeral to integer
 *
 * @param string $string the roman numeral
 * 
 * @return integer
 */
	public function parse($string);

}