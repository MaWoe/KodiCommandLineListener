#!/usr/bin/env php
<?php

use Mosh\KodiCommandLineListener\DelayedOffRasPirCommand;
use Mosh\KodiCommandLineListener\KodiCommandLineListener;
use Mosh\KodiCommandLineListener\KodiEventMap;
use Mosh\KodiCommandLineListener\RasPirClient;
use Mosh\KodiCommandLineListener\RasPirCommand;
use Mosh\KodiCommandLineListener\RasPirVolumeCommand;
use Mosh\KodiCommandLineListener\YoutubeDownload;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$logger = new ConsoleLogger(
    new ConsoleOutput(
#        OutputInterface::VERBOSITY_DEBUG
        OutputInterface::VERBOSITY_NORMAL
    )
);

$raspirClient = new RasPirClient('/home/pi/RasPir');

$onCommand = new RasPirCommand($raspirClient, 'raspiOn.sh');
$offCommand = new DelayedOffRasPirCommand($raspirClient, 'off.sh &', $logger);
$volumeCommand = new RasPirVolumeCommand($raspirClient);

$ytCommand = new YoutubeDownload();

$listener = new KodiCommandLineListener($logger);

$listener->registerCommandOnEvent('Other.YOUTUBE_URL', $ytCommand);

$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPAUSE, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONSTOP, $offCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPLAY, $offCommand);

$listener->registerCommandOnEvent(KodiEventMap::EVENT_PLAYER_ONPLAY, $onCommand);
$listener->registerCommandOnEvent(KodiEventMap::EVENT_APPLICATION_ONVOLUMECHANGED, $volumeCommand);

$listener->run();
