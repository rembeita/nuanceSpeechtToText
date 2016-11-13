#!/bin/bash
AUDIOFILE=$1
CODEC=$2
RATE=$3
LANGUAGE=$4
export GOOGLE_APPLICATION_CREDENTIALS="speechtest.json"
export GCLOUD_PROJECT="speechtestnuance"
python transcribe.py $AUDIOFILE $CODEC $RATE $LANGUAGE
