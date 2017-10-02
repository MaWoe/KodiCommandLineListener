<?php
namespace Mosh\KodiCommandLineListener;

class RasPirCommand implements Command
{
    private $client;

    private $raspirCommand;

    public function __construct(RasPirClient $client, $raspirCommand)
    {
        $this->client = $client;
        $this->raspirCommand = $raspirCommand;
    }

    public function execute(KodiEventNotification $eventNotification)
    {
        $this->client->executeCommand($this->raspirCommand);
    }

    public function processHeartBeat()
    {
    }
}