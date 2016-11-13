#!/bin/bash
AUDIOFILE=$1
#AUDIOFILE="gs://translatespeech/ZOOM0005_MONO_converted.wav"
CODEC=$2
#CODEC="LINEAR16"
RATE=$3
#RATE="16000"
LANGUAGE=$4
#LANGUAGE="en-US"
export GOOGLE_APPLICATION_CREDENTIALS="speechtest.json"
export GCLOUD_PROJECT="speechtestnuance"
#python transcribe_async.py $AUDIOFILE $CODEC $RATE $LANGUAGE
#python transcribe_async.py gs://translatespeech/ZOOM0005_MONO_converted.wav
python transcribe_async.py $AUDIOFILE $CODEC $RATE $LANGUAGE 
#python transcribe_async.py gs://translatespeech/ZOOM0005_MONO_converted.wav
