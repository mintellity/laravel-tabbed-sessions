docker run -it \
    --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    --entrypoint /bin/bash \
    laravelsail/php82-composer:latest
