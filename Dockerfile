FROM webdevops/php-nginx:latest

# Install selected extensions and other stuff
RUN apt-get update 


WORKDIR "/app"