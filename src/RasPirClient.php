<?php
namespace Mosh\KodiCommandLineListener;

class RasPirClient
{
    private $raspirInstallationDir;

    const VOLUME_UP = 'volumeUp.sh';

    const VOLUME_DOWN = 'volumeDown.sh';

    const RASPI_ON = 'raspiOn.sh';

    const OFF = 'off.sh';

    /**
     * @param string $raspirInstallationDir
     */
    public function __construct($raspirInstallationDir)
    {
        $this->raspirInstallationDir = $raspirInstallationDir;
    }

    public function volumeUp()
    {
        $this->executeCommand(self::VOLUME_UP);
    }

    public function volumeDown()
    {
        $this->executeCommand(self::VOLUME_DOWN);
    }

    public function raspiOn()
    {
        $this->executeCommand(self::RASPI_ON);
    }

    public function off()
    {
        $this->executeCommand(self::OFF);
    }

    public function executeCommand($command)
    {
        exec($this->raspirInstallationDir . '/' . $command);
    }
}