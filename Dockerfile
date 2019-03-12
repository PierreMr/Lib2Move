FROM webdevops/php-nginx:latest

RUN apt-get update \
	&& apt install curl \
	&& curl -sL https://deb.nodesource.com/setup_10.x | bash \
	&& apt install npm \
	&& npm install sass-loader node-sass --dev \
	&& npm install
