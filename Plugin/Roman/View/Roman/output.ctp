<?php
if (empty($status)) {
	$this->request->params['ext'] = 'json';	
}

$this->request->params['ext'] = !empty($this->request->params['ext']) ? $this->request->params['ext'] : 'json';
switch ($this->request->params['ext']) {
	case 'json':
		$out = json_encode(array('conversion' => compact($_serialize)));
		break;

	case 'html':
		$out = $this->Html->tag('div', implode('', array(
			$this->Html->tag('h3', 'Conversion'),
			$this->Html->tag('ul', implode('', array(
				$this->Html->tag('li', $this->Html->tag('strong', 'Roman') . ': ' . $roman),
				$this->Html->tag('li', $this->Html->tag('strong', 'Integer') . ': ' . $integer),
			)))
		)));
		break;

	case 'xml':
		$out = Xml::fromArray(array('conversion' => compact($_serialize)), array('format' => 'tags'))->asXML();
		break;
}
echo $out;