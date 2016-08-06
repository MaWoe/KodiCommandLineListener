<?php
namespace Mosh\KodiCommandLineListener;

class RasPirCommand implements Command
{
    const RASPIR_FOLDER = '/home/pi/RasPir';

    const VOLUME_UP = 'volumeUp.sh';

    const VOLUME_DOWN = 'volumeDown.sh';

    private $raspirCommand;

    public function __construct($raspirCommand)
    {
        $this->raspirCommand = $raspirCommand;
    }

    public function execute(KodiEventNotification $eventNotification)
    {
        $command = self::RASPIR_FOLDER . '/' . $this->raspirCommand;
        exec($command);
    }
}