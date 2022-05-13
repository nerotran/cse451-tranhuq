#!/bin/bash

URL=https://UID.451.csi.miamioh.edu/cse451-UID-web/final-rest/......  (what ever completes this path to your api)

#add some data.

echo "add data"
curl -k -X "POST" -H 'content-type: application/json' -d '{"name":"test"}' ${URL}

echo


#get the data

echo "get data"
curl -k -X "GET" ${URL}
echo

#append some data

echo "append more data"
curl -k -X "POST" -H 'content-type: application/json' -d '{"name":"exam"}' ${URL}
echo

#get it

echo "get data"
curl -k -X "GET" ${URL}
echo

#delete it all

echo 'Delete date'
curl -k -X "DELETE" ${URL}
echo

#verify it is gone

echo "verify its gone"
curl -k -X "GET" ${URL}
echo
