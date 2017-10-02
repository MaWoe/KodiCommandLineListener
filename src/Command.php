<?php
namespace Mosh\KodiCommandLineListener;

interface Command
{
    public function execute(KodiEventNotification $eventNotification);

    public function processHeartBeat();
}