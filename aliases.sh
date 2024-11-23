# Аллиасы для проекта

#Для Git Bash

#  запускает Docker Compose с указанным файлом окружения и поднимает все сервисы.
alias dcup='winpty docker-compose --env-file ./api/.env up'

# останавливает и удаляет все контейнеры Docker Compose
alias dcdown='winpty docker-compose down'

# собирает образы Docker Compose
alias dcbuild='winpty docker-compose --env-file ./api/.env build --no-cache'

#перезапускает все сервисы Docker Compose
alias dcrestart='winpty docker-compose restart'

#показывает логи всех сервисов Docker Compose в режиме следования.
alias dclogs='winpty docker-compose logs -f'

#запускает composer update внутри контейнера api-vue-laravel-app
alias dcexec='winpty docker exec -it api-vue-laravel-app composer update'

# Для PowerShell
# function dcup { docker-compose --env-file ./api/.env up $args }
# function dcdown { docker-compose down $args }
# function dcbuild { docker-compose build $args }
# function dcrestart { docker-compose restart $args }
# function dclogs { docker-compose logs -f $args }
# function dcexec { docker exec -it api-vue-laravel-app composer update }