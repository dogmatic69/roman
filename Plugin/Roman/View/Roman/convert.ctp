<div class="row">
	<div class="col-md-6">
		<h3>Input</h3>
		<?php
			echo implode('', array(
				$this->Form->create(null, array(
						'id' => 'convert',
						'inputDefaults' => array(
							'label' => false,
							'class' => 'form-control',
							'div' => 'form-group',
							'empty' => 'Please Select',
						)
					)),
					$this->Form->input('roman_numeral', array(
						'placeholder' => 'Roman Numeral',
					)),
					$this->Form->input('integer', array(
						'placeholder' => 'Integer',
						'type' => 'number',
						'step' => 1,
						'min' => 1,
						'max' => 3999,
					)),
					$this->Form->input('type', array(
						'options' => array(
							'json' => 'JSON',
							'xml' => 'XML',
							'html' => 'HTML',
						),
					)),
					$this->Form->submit('Convert'),
				$this->Form->end(),
			));
		?>
	</div>
	<div class="col-md-6">
		<h3>Output</h3>
		<textarea id="output" class="col-md-12" rows="9"></textarea>
	</div>
</div>