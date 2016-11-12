#!/bin/bash
AUDIOFILE=$1
#AUDIOFILE=audio.raw
CODEC=$2
#CODEC="LINEAR16"
RATE=$3
#RATE="16000"
LANGUAGE=$4
#LANGUAGE="en-US"
export GOOGLE_APPLICATION_CREDENTIALS="speechtest.json"
export GCLOUD_PROJECT="speechtestnuance"
#python transcribe.py $AUDIOFILE $LANGUAGE $CODEC $RATE
python transcribe.py $AUDIOFILE $CODEC $RATE $LANGUAGE
