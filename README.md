# PHP x Docker

following some course on PHP...

you might need to update the volumes in `docker-compose.yml`

```shell
docker compose up -d
```

```shell
sudo docker exec php_procedural-php-1 composer init
```

```shell
docker run -it --rm -v $(pwd):/code ghcr.io/php-cs-fixer/php-cs-fixer:${FIXER_VERSION:-3-php8.3} fix src
```

- <https://php.captainhook.info/install.html>
- <https://cs.symfony.com/doc/installation.html>
- <https://phpstan.org/user-guide/getting-started>
