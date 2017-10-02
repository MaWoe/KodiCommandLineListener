<?php
namespace Mosh\KodiCommandLineListener;

class RasPirVolumeCommand implements Command
{
    private $client;

    private $lastVolume;

    public function __construct(RasPirClient $client)
    {
        $this->client = $client;
    }

    public function execute(KodiEventNotification $eventNotification)
    {
        $data = $eventNotification->data;
        $volume = (int)$data['volume'];
        $lastVolume = $this->lastVolume;
        $this->lastVolume = $volume;

        if ($volume == 100) {
            $this->client->volumeUp();
        } elseif ($volume <= 90 && $volume < $lastVolume) {
            $this->client->volumeDown();
        }
    }

    public function processHeartBeat()
    {
    }
}