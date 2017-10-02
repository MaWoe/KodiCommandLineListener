#!/bin/bash

BASE=$(dirname $(readlink -f $0))
LOG="$BASE/../listen.log"

while true; do
    ${BASE}/listen.php
    sleep 10
done
