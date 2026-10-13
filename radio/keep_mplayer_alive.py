#!/usr/bin/env python
import os
import subprocess

def getActiveStation():
    activeStation = ""

    f = open("/home/pi/radio/active.txt", "r")
    activeLine = f.readline()
    f.close()

    if not activeLine:
        activeLine = 1

    f = open("/home/pi/radio/radio.list", "r")
    for x in f:
        elements = x.split("__")
        if int(elements[0]) == 1: defaultStation = elements[2]
        if int(elements[0]) == int(activeLine):
            activeStation = elements[2]
    f.close()

    if not activeStation:
        activeStation = defaultStation

    return activeStation.strip()

cmd = "ps -aux | grep 'mplayer'"
ps = subprocess.Popen(cmd,shell=True,stdout=subprocess.PIPE,stderr=subprocess.STDOUT)
output = ps.communicate()[0]

stringsOfOutput = output.splitlines()

runningProcessFound = False

for line in stringsOfOutput:
    if line.find('mplayer') >= 0 and line.find('http') >= 0:
        runningProcessFound = True

url = getActiveStation()
mplayerOption = ""
if url.find('.pls') >= 0 or url.find('.m3u') >= 0:
    mplayerOption = " -playlist"


if runningProcessFound == False:
    os.system("mplayer " + mplayerOption + " " + url + " < /dev/null > /dev/null 2>&1 &")

