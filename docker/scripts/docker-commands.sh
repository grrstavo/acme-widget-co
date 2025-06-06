#!/bin/bash

case "$1" in
    "up")
        docker-compose up -d
        ;;
    "down")
        docker-compose down
        ;;
    "build")
        docker-compose build
        ;;
    "composer")
        docker-compose exec app composer "${@:2}"
        ;;
    "test")
        docker-compose exec app composer test
        ;;
    "phpstan")
        docker-compose exec app composer phpstan
        ;;
    "shell")
        docker-compose exec app bash
        ;;
    *)
        echo "Available commands:"
        echo "  up        - Start containers"
        echo "  down      - Stop containers"
        echo "  build     - Rebuild containers"
        echo "  composer  - Run composer commands"
        echo "  test      - Run tests"
        echo "  phpstan   - Run PHPStan"
        echo "  shell     - Open shell in app container"
        ;;
esac 