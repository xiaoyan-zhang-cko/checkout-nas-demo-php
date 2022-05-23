# Checkout FOUR(NAS) Demo PHP with SDK 

## Getting started
###To install checkout-sdk-php
https://github.com/checkout/checkout-sdk-php

Add ``composer.json`` and Run ``composer install``

```json
"require": {
    "php": ">=5.6",
    "checkout/checkout-sdk-php": "version"
}
```

#### FOUR(NAS) document
https://www.checkout.com/docs/four

#### FOUR(NAS) API reference
https://api-reference.checkout.com/preview/crusoe/

###

### Using PHP Server
Copy project to your server folder such as:
``server\xampp\htdocs``

###

### Using Docker
#### Build an image with name demo
``docker image build -t demo .``

#### Launch a container with command line instead of docker-compose.xml
ex: php8container is container name, demo is the image name
``docker run -it --rm -p 8080:80 -p 443:443 --name php8container -v "$PWD":/var/www/html demo``

#### Start docker and image names from docker-compose.xml
``docker-compose up``

#### Go into a container and execute bash command
``docker exec -it {{containerId}} bash``

#### Stop docker
``docker-compose down``

#### List all running dockers
``docker ps -a -q``

#### Stop or delete a running docker container
``docker stop/rm ${id}``

#### Stop or delete all running dockers
``docker stop/rm $(docker ps -a -q)``

#### List image
``docker image ls`` or ``docker images -a``

#### Remove an image
``docker image rm <image_id>``

#### Remove EVERYTHING !!!!!!!!!!!!!!!!!!!!!!
``docker system prune -a``
