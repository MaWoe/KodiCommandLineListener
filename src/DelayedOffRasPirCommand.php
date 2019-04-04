<?php
namespace Mosh\KodiCommandLineListener;

use Psr\Log\LoggerInterface;

class DelayedOffRasPirCommand implements Command
{
    const EVENTS_TO_SHUTDOWN = array(
        KodiEventMap::EVENT_PLAYER_ONPAUSE,
        KodiEventMap::EVENT_PLAYER_ONSTOP
    );
    const DELAY = 30;

    /**
     * @var RasPirClient
     */
    private $client;

    /**
     * @var string
     */
    private $raspirCommand;

    /**
     * UNIX timestamp
     *
     * @var int
     */
    private $timerStartedAt;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RasPirClient $client, $raspirCommand, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->raspirCommand = $raspirCommand;
        $this->logger = $logger;
    }

    public function execute(KodiEventNotification $eventNotification)
    {
        if (!isset($eventNotification->data['item']['type']) || $eventNotification->data['item']['type'] === 'picture') {
          return;
        } else if (in_array($eventNotification->eventName, self::EVENTS_TO_SHUTDOWN)) {
            $this->startTimer();
        } else {
            $this->stopTimer();
        }
    }

    private function startTimer()
    {
        if ($this->timerStartedAt === null) {
            $this->logger->debug('Timer started');
            $this->timerStartedAt = time();
        }
    }

    private function stopTimer()
    {
        $this->timerStartedAt = null;
    }

    private function hasTimerExpired()
    {
        if ($this->timerStartedAt === null) {
            return false;
        }

        $timeElapsed = time() - $this->timerStartedAt;
        $this->logger->debug('Elapsed: ' . $timeElapsed);

        return $timeElapsed > self::DELAY;
    }

    public function processHeartBeat()
    {
        if ($this->hasTimerExpired()) {
            $this->logger->debug('Timer expired');
            $this->client->executeCommand($this->raspirCommand);
            $this->stopTimer();
        }
    }
}
