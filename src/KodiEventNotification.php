<?php
namespace Mosh\KodiCommandLineListener;

class KodiEventNotification
{
    public $eventName;

    public $data;

    public $sender;

    /**
     * @param array $notificationArray
     * @return KodiEventNotification
     */
    public static function createFromNotificationArray(array $notificationArray)
    {
        $instance = new KodiEventNotification();
        $instance->eventName = $notificationArray['method'];

        $params = $notificationArray['params'];
        $instance->data = $params['data'];
        $instance->sender = $params['sender'];

        return $instance;
    }
}