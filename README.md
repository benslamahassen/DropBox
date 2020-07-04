# Dropbox
Disclaimer: This is not the real Dropbox.

## Installation

```bash
git clone https://github.com/benslamahassen/DropBox.git
```

## Usage

```bash
cd ./DropBox/docker
```

```bash
docker-compose build`
```

```bash
docker-compose up
```
Make sure that **mysql container** is up and listening for requests
```bash
docker exec -it php php ./bin/console doctrine:database:create
```

```bash
docker exec -it php php ./bin/console doctrine:migrations:migrate
```

## Motivation
Made with :heart: :smirk:, HBS.
Read more about Symfony [here](https://www.symfony.com/doc/current/index.html).

## License
[MIT](https://choosealicense.com/licenses/mit/)