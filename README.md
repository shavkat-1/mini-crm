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
