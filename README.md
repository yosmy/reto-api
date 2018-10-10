# Dev

docker network create frontend

docker network create backend

export UID
export GID
docker-compose \
-f docker/common.yml \
-f docker/dev.yml \
-p reto_api \
up -d --remove-orphans --force-recreate

# Prod

docker network create frontend

docker network create backend

cd proxy
docker-compose -f docker/yml -p proxy up -d
cd ..

cd reto-api

export UID
export GID
docker-compose \
-f docker/common.yml \
-f docker/prod.yml \
-p reto_api \
up -d --remove-orphans --force-recreate


# Install

composer install

cp config/parameters.dist.yml config/parameters.yml

nano config/parameters.yml

chmod 777 -R var/*

# Test
