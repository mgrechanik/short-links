# Функционал коротких ссылок на Yii2 проекте

[Текст задания](https://raw.githubusercontent.com/mgrechanik/short-links/refs/heads/main/short_links_test_task.png)

## Установка

1) Клонируем репозиторий
2) запускаем из корня composer install
3) создаем БД, например short_link и указываем ее в config/db.php
4) Запускаем миграции  yii migrate up
5) В файле config/params.php устанавливаем домен сайта - 'shortLinkPrefix' => 'http://short-link.front/',
6) Запустить на вебсервере Apache2, ну или Nginx, чтобы чистые ссылки работали как в yii документации указано

## Результат

Вставляем ссылки, например:
  - https://www.yiiframework.com/doc/guide/2.0/en/db-active-record
  - https://поддерживаю.рф/
  - https://phpforum.su/index.php?act=Search&CODE=getactive
  
### Получаем короткую ссылку вида:

http://short-link.front/sl/Wb2R4

### Как это выглядит

![Functionality of category we get](https://raw.githubusercontent.com/mgrechanik/short-links/refs/heads/main/slink.jpg "Короткие ссылки")

