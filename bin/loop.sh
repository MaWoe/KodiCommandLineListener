#!/bin/bash

BASE=$(dirname $(readlink -f $0))

while true; do
    $BASE/listen.php
    sleep 10
done
