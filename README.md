cd ./DropBox
docker-compose build
docker-compose up
docker exec -it php php ./bin/console doctrine:database:create 
docker exec -it php php ./bin/console doctrine:migrations:migrate