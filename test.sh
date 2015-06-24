#!/bin/bash
zipname=$1
cd zips
unzip $zipname -d ${zipname%.*}
echo ${zipname%.*}/*
cp ${zipname%.*}/* ../test/