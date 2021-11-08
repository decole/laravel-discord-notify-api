#!/bin/bash

set -ex

cat ~/.docker_password.txt | docker login --username 13123123 --password-stdin

docker build -f HubDockerfile --no-cache --rm -t discor-notificator:latest .
docker tag discor-notificator:latest 13123123/discor-notificator:latest
docker push 13123123/discor-notificator:latest
