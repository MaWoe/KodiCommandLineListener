<?php

namespace Mosh\KodiCommandLineListener;

use Psr\Log\LoggerInterface;
use SplObjectStorage;

class KodiCommandLineListener
{
    const HOST = '127.0.0.1';

    const PORT = 9090;

    /**
     * @var SplObjectStorage[]
     */
    private $eventToCommandMap = array();

    /**
     * @var SplObjectStorage
     */
    private $allCommands;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->allCommands = new SplObjectStorage();
        $this->logger = $logger;
    }

    public function registerCommandOnEvent($eventName, Command $command)
    {
        $splObjectStorage = $this->getSplObjectStorageByEventName($eventName);
        if (!$splObjectStorage->contains($command)) {
            $splObjectStorage->attach($command);
        }

        if (!$this->allCommands->contains($command)) {
            $this->allCommands->attach($command);
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
            if (socket_select($read, $write, $except, 1) > 0) {
                $result = socket_read($socket, 1024 * 16);
                $eventInformation = json_decode($result, true);
                if (!is_array($eventInformation)) {
                    $this->logger->warning('Malformed event: ' . $result);
                } else {
                    $this->dispatchMethod($eventInformation);
                }
            }

            $this->sendHeartBeatToCommands();
        }
    }

    private function dispatchMethod(array $eventInformation)
    {
        $notification = KodiEventNotification::createFromNotificationArray($eventInformation);
        $eventName = $notification->eventName;

        $this->logger->debug('Dispatching event "' . $eventName . '"');
        $this->logger->debug(print_r($notification, true));
        if ($this->hasCommandsByEvent($eventName)) {
            /** @var Command $command */
            foreach ($this->getSplObjectStorageByEventName($eventName) as $command) {
                $command->execute($notification);
            }
        } else {
            $this->logger->debug('No listeners');
        }
    }

    private function sendHeartBeatToCommands()
    {
        $this->logger->debug('Sending heartbeat');

        /** @var Command $command */
        foreach ($this->allCommands as $command) {
            $command->processHeartBeat();
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
