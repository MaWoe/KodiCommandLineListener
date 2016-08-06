<?php

namespace Mosh\KodiCommandLineListener;

use SplObjectStorage;

class KodiCommandLineListener
{
    const HOST = 'mypi.home';

    const PORT = 9090;

    const METHOD_ON_PLAY = 'Player.OnPlay';

    const METHOD_ON_STOP = 'Player.OnStop';

    const METHOD_ON_PAUSE = 'Player.OnPause';

    const RASPIR_HOME = '/home/pi/RasPir';

    private $eventToCommandMap = array();

    public function registerCommandOnEvent($eventName, Command $command)
    {
        $splObjectStorage = $this->getSplObjectStorageByEventName($eventName);
        if (!$splObjectStorage->contains($command)) {
            $splObjectStorage->attach($command);
        }
    }

    /**
     * @param string $eventName
     * @return bool
     */
    public function hasCommandsByEvent($eventName)
    {
        return isset($this->eventToCommandMap[$eventName]);
    }

    /**
     * @param $eventName
     * @return SplObjectStorage
     */
    private function getSplObjectStorageByEventName($eventName)
    {
        if (!isset($this->eventToCommandMap[$eventName])) {
            $this->eventToCommandMap[$eventName] = new SplObjectStorage();
        }

        return $this->eventToCommandMap[$eventName];
    }

    public function run()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->throwExceptionOnFalse($socket, 'Could not create socket');

        $result = socket_connect($socket, self::HOST, self::PORT);
        $this->throwExceptionOnFalse($result, 'Could not connect');

        while (true) {
            $read = array($socket);
            $write = array();
            $except = array();
            if (socket_select($read, $write, $except, 60) > 0) {
                $result = socket_read($socket, 1024 * 16);
                $eventInformation = json_decode($result, true);
                $this->dispatchMethod($eventInformation);
            }
        }
    }

    private function dispatchMethod(array $eventInformation)
    {
        $notification = KodiEventNotification::createFromNotificationArray($eventInformation);
        $eventName = $notification->eventName;

        echo 'Dispatching event "' . $eventName . '"', PHP_EOL;
        if ($this->hasCommandsByEvent($eventName)) {
            /** @var Command $command */
            foreach ($this->getSplObjectStorageByEventName($eventName) as $command) {
                $command->execute($notification);
            }
        } else {
            echo 'No listeners', PHP_EOL;
        }
    }

    /**
     * @param $result
     * @param $message
     * @throws \Exception
     */
    private function throwExceptionOnFalse($result, $message)
    {
        if ($result === false) {
            throw new \Exception($message);
        }
    }
}
