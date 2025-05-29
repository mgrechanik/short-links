# Функционал коротких ссылок на Yii2 проекте

## Установка

1) Клонируем репозиторий
2) запускаем из корня composer install
3) создаем БД, например short_link и указываем ее в config/db.php
4) Запускаем миграции  yii migrate up
5) В файле config/params.php устанавливаем домен сайта - 'shortLinkPrefix' => 'http://short-link.front/',
6) Запустить на версервере Apache2

## Результат

Вставляем ссылки на пример:
  - https://www.yiiframework.com/doc/guide/2.0/en/db-active-record
  - https://поддерживаю.рф/
  - https://phpforum.su/index.php?s=898f9b75eea64723de2c5097fc4f6969&act=Search&CODE=getactive
  
### Получаем короткую ссылку вида:

http://short-link.front/sl/Wb2R4

### Как это выглядит

![Functionality of category we get](https://raw.githubusercontent.com/mgrechanik/short-links/refs/heads/main/slink.jpg "Короткие ссылки")

