#!/bin/bash

SCREEN_NAME="kodiCommandLineListener"
BASE=$(dirname $(readlink -f $0))

if [ ! $UID = 0 ]; then
    echo "Script may only run as root"
    exit 1
fi

is_running() {
    if screen -ls | grep -q ${SCREEN_NAME}; then
        return 0
    else
        return 1
    fi
}

case "$1" in
    start)
        if is_running; then
            echo "Named screen \"$SCREEN_NAME\" is already running. Exiting here."
            exit 1
        else
            screen -dmS ${SCREEN_NAME} $BASE/loop.sh
            echo "Started named screen \"$SCREEN_NAME\""
            exit 0
        fi
        ;;
    stop)
        if ! is_running; then
            echo "Nothing to stop"
            exit 1
        fi

        PID=$(screen -ls | grep $SCREEN_NAME | sed --regexp-extended 's/^\s*([0-9]+)\..*/\1/g')
        if kill -9 ${PID}; then
            screen -wipe $SCREEN_NAME
            echo "Stopped"
            exit 0
        else
            echo "Could not stop"
            exit 1
        fi
        ;;
    status)
        if is_running; then
            echo "Running"
            exit 0
        else
            echo "Not running"
            exit 1
        fi
        ;;
    *)
      echo "Usage: $0 {start|stop|status}"
      exit 1
      ;;
esac



