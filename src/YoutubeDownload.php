<?php
namespace Mosh\KodiCommandLineListener;

class YoutubeDownload implements Command
{
    public function execute(KodiEventNotification $eventNotification)
    {
       $uri = $eventNotification->data['uri'];
       echo "DOWNLOADING YOUTUBE_URL: " . $uri . "\n";
       exec('curl \'' . $uri . '\' > /media/SAMSUNG/Music/YoutubeDownloads/' . md5($uri) . '.mp3 &');
    }

    public function processHeartBeat()
    {
    }
}
