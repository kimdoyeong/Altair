<?php
require __DIR__.'/lib/basic.php';

load('controller/Controller');


ControlHandler::NewAction('home', null, 'wiki');
ControlHandler::NewAction('view', null, 'view');
ControlHandler::NewAction('new', null, 'newwiki');
ControlHandler::NewAction('handle', null, 'handle');
ControlHandler::NewAction('edit', null, 'edit');
ControlHandler::NewAction('random', null, 'random');

$page = new Controller();

?>