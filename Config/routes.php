<?php
Router::parseExtensions('json', 'xml', 'html');
Router::connect('/', array('plugin' => 'roman', 'controller' => 'roman', 'action' => 'convert'));

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
