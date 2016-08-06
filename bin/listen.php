#!/usr/bin/env php
<?php

use Mosh\KodiCommandLineListener\KodiCommandLineListener;
use Mosh\KodiCommandLineListener\KodiEventMap;
use Mosh\KodiCommandLineListener\RasPirCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$onCommand = new RasPirCommand('raspiOn.sh');
$offCommand = new RasPirCommand('off.sh');
$volumeUpCommand = new RasPirCommand('volumeUp.sh');
$volumeDownCommand = new RasPirCommand('volumeDown.sh');

$listener = new KodiCommandLineListener();
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPAUSE, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONSTOP, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPLAY, $onCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_APPLICATION_ONVOLUMECHANGED, $volumeDownCommand);

$listener->run();