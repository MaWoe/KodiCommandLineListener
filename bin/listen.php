#!/usr/bin/env php
<?php

use Mosh\KodiCommandLineListener\KodiCommandLineListener;
use Mosh\KodiCommandLineListener\KodiEventMap;
use Mosh\KodiCommandLineListener\RasPirClient;
use Mosh\KodiCommandLineListener\RasPirCommand;
use Mosh\KodiCommandLineListener\RasPirVolumeCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$raspirClient = new RasPirClient('/home/pi/RasPir');

$onCommand = new RasPirCommand($raspirClient, 'raspiOn.sh');
$offCommand = new RasPirCommand($raspirClient, 'off.sh');
$volumeCommand = new RasPirVolumeCommand($raspirClient);

$listener = new KodiCommandLineListener();
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPAUSE, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONSTOP, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPLAY, $onCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_APPLICATION_ONVOLUMECHANGED, $volumeCommand);

$listener->run();