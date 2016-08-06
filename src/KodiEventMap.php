<?php
namespace Mosh\KodiCommandLineListener;

interface KodiEventMap
{
    const EVENT_APPLICATION_ONVOLUMECHANGED = 'Application.OnVolumeChanged';
    const EVENT_AUDIOLIBRARY_ONCLEANFINISHED = 'AudioLibrary.OnCleanFinished';
    const EVENT_AUDIOLIBRARY_ONCLEANSTARTED = 'AudioLibrary.OnCleanStarted';
    const EVENT_AUDIOLIBRARY_ONREMOVE = 'AudioLibrary.OnRemove';
    const EVENT_AUDIOLIBRARY_ONSCANFINISHED = 'AudioLibrary.OnScanFinished';
    const EVENT_AUDIOLIBRARY_ONSCANSTARTED = 'AudioLibrary.OnScanStarted';
    const EVENT_AUDIOLIBRARY_ONUPDATE = 'AudioLibrary.OnUpdate';
    const EVENT_GUI_ONDPMSACTIVATED = 'GUI.OnDPMSActivated';
    const EVENT_GUI_ONDPMSDEACTIVATED = 'GUI.OnDPMSDeactivated';
    const EVENT_GUI_ONSCREENSAVERACTIVATED = 'GUI.OnScreensaverActivated';
    const EVENT_GUI_ONSCREENSAVERDEACTIVATED = 'GUI.OnScreensaverDeactivated';
    const EVENT_INPUT_ONINPUTFINISHED = 'Input.OnInputFinished';
    const EVENT_INPUT_ONINPUTREQUESTED = 'Input.OnInputRequested';
    const EVENT_PLAYER_ONPAUSE = 'Player.OnPause';
    const EVENT_PLAYER_ONPLAY = 'Player.OnPlay';
    const EVENT_PLAYER_ONPROPERTYCHANGED = 'Player.OnPropertyChanged';
    const EVENT_PLAYER_ONSEEK = 'Player.OnSeek';
    const EVENT_PLAYER_ONSPEEDCHANGED = 'Player.OnSpeedChanged';
    const EVENT_PLAYER_ONSTOP = 'Player.OnStop';
    const EVENT_PLAYLIST_ONADD = 'Playlist.OnAdd';
    const EVENT_PLAYLIST_ONCLEAR = 'Playlist.OnClear';
    const EVENT_PLAYLIST_ONREMOVE = 'Playlist.OnRemove';
    const EVENT_SYSTEM_ONLOWBATTERY = 'System.OnLowBattery';
    const EVENT_SYSTEM_ONQUIT = 'System.OnQuit';
    const EVENT_SYSTEM_ONRESTART = 'System.OnRestart';
    const EVENT_SYSTEM_ONSLEEP = 'System.OnSleep';
    const EVENT_SYSTEM_ONWAKE = 'System.OnWake';
    const EVENT_VIDEOLIBRARY_ONCLEANFINISHED = 'VideoLibrary.OnCleanFinished';
    const EVENT_VIDEOLIBRARY_ONCLEANSTARTED = 'VideoLibrary.OnCleanStarted';
    const EVENT_VIDEOLIBRARY_ONREMOVE = 'VideoLibrary.OnRemove';
    const EVENT_VIDEOLIBRARY_ONSCANFINISHED = 'VideoLibrary.OnScanFinished';
    const EVENT_VIDEOLIBRARY_ONSCANSTARTED = 'VideoLibrary.OnScanStarted';
    const EVENT_VIDEOLIBRARY_ONUPDATE = 'VideoLibrary.OnUpdate';
}

