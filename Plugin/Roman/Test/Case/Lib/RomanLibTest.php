<?php 
App::uses('RomanLib', 'Roman.Lib');

/**
 * Test class for roman numerals lib
 */
class RomanLibTest extends CakeTestCase {

/**
 * Setup the class being tested
 */
	public function setup() {
		parent::setup();

		$this->Lib = new RomanLib();
	}

/**
 * validate roman numerals
 *
 * @dataProvider validateRomanDataProvider
 */
	public function testValidateRoman($data, $expected) {
		$this->assertEquals($expected, $this->Lib->validateRoman($data));
	}

	public function validateRomanDataProvider() {
		return array(
			'I' => array(
				'I',
				true,
			),
			'Lowercase I' => array(
				'i',
				true,
			),
			'V' => array(
				'V',
				true,
			),
			'X' => array(
				'X',
				true,
			),
			'MMMCMXCIX' => array(
				'MMMCMXCIX',
				true
			),
			'MMMMMMMMMMMMMMMMMM' => array(
				'MMMMMMMMMMMMMMMMMM',
				true
			),
			'A' => array(
				'A',
				false
			),
			'XIA' => array(
				'XIA',
				false
			),
		);
	}

/**
 * validate roman numerals
 *
 * @dataProvider validateIntegerDataProvider
 */
	public function testValidateInteger($data, $expected) {
		$this->assertEquals($expected, $this->Lib->validateInteger($data));
	}

	public function validateIntegerDataProvider() {
		return array(
			1 => array(
				1,
				true,
			),
			'1 string' => array(
				'1',
				true,
			),
			'1 float' => array(
				1.0,
				true,
			),
			'1 float string' => array(
				'1.0',
				true,
			),
			99.99 => array(
				99.99,
				false,
			),
			'99.99 string' => array(
				'99.99',
				false,
			)
		);
	}
	
/**
 * test parse invalid exceptin
 * 
 * @expectedException InvalidRomanNumeralException
 */
	public function testParseInvalidException() {
		$this->Lib->parse('ASDF');
	}
	
/**
 * test parse invalid exceptin
 * 
 * @expectedException RomanNumeralTooLargeException
 */
	public function testParseTooLargeException() {
		$this->Lib->parse('MMMM');
	}
	
/**
 * test parse with mocked parser, make sure the method is called the correct number of times
 *
 * @dataProvider testParseDataProvider
 */
	public function testParse($data, $expected) {
		$this->Lib = $this->getMock('RomanLib', array('parseSingle', 'validateRoman', '_romanMap'));
		$this->Lib
			->expects($this->any())
			->method('validateRoman')
			->will($this->returnValue(true));

		$this->Lib
			->expects($this->any())
			->method('_romanMap')
			->will($this->returnValue($data));

		$this->Lib
			->expects($this->any())
			->method('parseSingle')
			->will($this->returnValue(5));

		$this->assertEquals($expected, $this->Lib->parse($data));
	}

	public function testParseDataProvider() {
		return array(
			'2 map' => array(
				array('A', 'B'),
				10,
			),
			'10 map' => array(
				range('a', 'j'),
				50,
			),
		);
	}

/**
 * test parse single
 *
 * @dataProvider parseSingleDataProvider
 */
	public function testParseSingle($data, $expected) {
		$result = $this->Lib->parseSingle($data['roman'], $data['key']);
		$this->assertEquals($data['post_processing_roman'], $data['roman']);
		$this->assertEquals($expected, $result);
	}

	public function parseSingleDataProvider() {
		return array(
			'I => 1' => array(
				array(
					'roman' => 'I',
					'key' => 'I',
					'post_processing_roman' => '',
				),
				1,
			),
			'V => 5' => array(
				array(
					'roman' => 'V',
					'key' => 'V',
					'post_processing_roman' => '',
				),
				5,
			),
			'X => 10' => array(
				array(
					'roman' => 'X',
					'key' => 'X',
					'post_processing_roman' => '',
				),
				10,
			),
			'IV' => array(
				array(
					'roman' => 'IV',
					'key' => 'I',
					'post_processing_roman' => '',
				),
				4,
			),
			'IX' => array(
				array(
					'roman' => 'IX',
					'key' => 'I',
					'post_processing_roman' => '',
				),
				9,
			),
			'XI - first pass' => array(
				array(
					'roman' => 'XI',
					'key' => 'X',
					'post_processing_roman' => 'I',
				),
				10,
			),
			'XI - second pass' => array(
				array(
					'roman' => 'I',
					'key' => 'I',
					'post_processing_roman' => '',
				),
				1,
			),
			'IX' => array(
				array(
					'roman' => 'IX',
					'key' => 'I',
					'post_processing_roman' => '',
				),
				9,
			),
			'XXX' => array(
				array(
					'roman' => 'XXX',
					'key' => 'X',
					'post_processing_roman' => '',
				),
				30,
			),
		);
	}

/**
 * test parse actual data
 *
 * @dataProvider parseActualDataProvider
 */
	public function testParseActual($data, $expected) {
		$this->assertEquals($expected, $this->Lib->parse($data));
	}

/**
 * tests with a couple known values (well, from wikipedia at least.)
 */
	public function parseActualDataProvider() {
		return array(
			'I' => array('I', 1),
			'V' => array('V', 5),
			'X' => array('X', 10),
			'L' => array('L', 50),
			'C' => array('C', 100),
			'D' => array('D', 500),
			'M' => array('M', 1000),

			'II' => array('II', 2),
			'IV' => array('IV', 4),
			'VI' => array('VI', 6),
			'IX' => array('IX', 9),
			'XI' => array('XI', 11),

			'VII' => array('VII', 7),

			'MCMLIV' => array('MCMLIV', 1954),
			'MCMXC' => array('MCMXC', 1990),
			'MMXIV' => array('MMXIV', 2014),
		);
	}
	
/**
 * test generate actual
 *
 * @dataProvider generateSingleDataProvider
 */
	public function testGenerateSingle($data, $expected) {
		$result = $this->Lib->generateSingle($data['integer'], $data['key']);
		$this->assertEquals($data['post_processing_integer'], $data['integer']);
		$this->assertEquals($expected, $result);
	}

	public function generateSingleDataProvider() {
		return array(
			'I => 1' => array(
				array(
					'integer' => 1,
					'key' => 'I',
					'post_processing_integer' => 0,
				),
				'I',
			),
			'V => 5' => array(
				array(
					'integer' => 5,
					'key' => 'V',
					'post_processing_integer' => 0,
				),
				'V',
			),
			'IV => 4' => array(
				array(
					'integer' => 4,
					'key' => 'IV',
					'post_processing_integer' => 0,
				),
				'IV',
			),
			'VVV => 15' => array(
				array(
					'integer' => 15,
					'key' => 'V',
					'post_processing_integer' => 0,
				),
				'VVV',
			),
			'XV => 15' => array(
				array(
					'integer' => 15,
					'key' => 'X',
					'post_processing_integer' => 5,
				),
				'X',
			),
		);
	}
	
/**
 * test generate actual
 *
 * @dataProvider generateActualDataProvider
 */
	public function testGenerateActual($data, $expected) {
		$this->assertEquals($expected, $this->Lib->generate($data));
	}

	public function generateActualDataProvider() {
		return array(
			1 => array(1, 'I'),
			4 => array(4, 'IV'),
			5 => array(5, 'V'),
			10 => array(10, 'X'),
			15 => array(15, 'XV'),
		);
	}

/**
 * pointless test that does brute force check on all values
 */
	public function testSelf() {
		foreach (range(1, 3999) as $integer) {
			$romanNumeral = $this->Lib->generate($integer);
			$this->assertEquals($integer, $this->Lib->parse($romanNumeral));
		}
	}

}