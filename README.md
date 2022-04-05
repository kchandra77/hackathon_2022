# Hackathon-2022

Voici mon projet hackathon-2022 pour l'entreprise Wired Beaty.

## Technologies in use
- [Symfony 5](https://symfony.com/doc/5.2/index.html)
- [Bootstrap](https://getbootstrap.com/docs/5.1/getting-started/introduction/)
- [Php-8.0](https://www.php.net/manual-lookup.php?pattern=php+unit&scope=quickref)
- [Docker](https://docs.docker.com/)
- [Git](https://git-scm.com/doc)

## Requirements
* [Install Docker](https://docs.docker.com/get-docker/) (with [docker-compose](https://docs.docker.com/compose/install/))
* [Git (With configured [SSH](https://docs.github.com/en/authentication/connecting-to-github-with-ssh) and [GPG](https://docs.github.com/en/authentication/managing-commit-signature-verification/generating-a-new-gpg-key) Keys for signed commits)

#### Start Application
```bash
docker-compose build --pull --no-cache
docker-compose up -d
docker-compose exec php composer install
```

#### Configuration
```text
# URL
http://127.0.0.1

# Env DB
DATABASE_URL="postgresql://postgres:password@db:5432/db?serverVersion=13&charset=utf8"
```

## Contributors
* Kurunchi CHANDRASEKARAM - [kchandra77](https://github.com/kchandra77)

