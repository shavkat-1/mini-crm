# Mini CRM — Сбор и обработка заявок

Мини CRM для сбора заявок с сайта через виджет и обработки их в административной панели.


Проект позволяет:

- Принимать заявки через виджет на сайте (`/widget`)  
- Сохранять заявки в базе с привязкой к клиенту (`Customer`)  
- Управлять заявками через админ-панель (только для менеджеров)  
- Сохранять файлы заявок через **spatie/laravel-medialibrary**  
- Ограничение: 1 заявка в сутки с одного номера или email  

- Проект покрыть migratios,factories,seeders для User,Customer, Ticket(с тестовыми данными,     включая менеджера и несколько заявок)


Технологии:

- Laravel 12, PHP 8.4  
- Blade UI для административной части и виджета  
- Spatie Laravel Permission для ролей  
- Spatie Medialibrary для файлов  
- API через Laravel Resources (TicketResource)  
- Swagger (L5-Swagger) для документации  


  Установка

1. Клонируем проект:

```bash
git clone <repo_url>
cd mini-crm


## Запуск через Docker

Проект можно запустить локально через Docker (без установки PHP и MySQL на хост-машину).

### Требования

- Docker ≥ 24.x  
- Docker Compose ≥ 2.x  

### 1. Настройка .env

Создайте .env (или проверьте существующий) и убедитесь, что настройки БД совпадают с Docker:

`env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=mini_crm
DB_USERNAME=sail
DB_PASSWORD=password

### 2. Сборка и запуск контейнеров 

docker compose up -d --build

### 3. Выполнение миграций

docker compose exec app php artisan migrate

### 4. Открыть проект 

После запуска приложение доступно по адресу:
http://localhost:8000

Полезные команды:

docker compose up -d          # запуск
docker compose down           # остановка
docker compose restart        # перезапуск
docker compose logs app       # логи Laravel (PHP)
docker compose logs web       # логи Nginx
docker compose logs db        # логи MySQL
