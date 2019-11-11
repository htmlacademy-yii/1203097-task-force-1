# Описание сущностей

## Сущность "задание"

### Свойства:  статус, исполнитель, заказчик, название, описание, категория, город, широта, долгота, бюджет, дата закрытия, прикрепленные файлы

### Связи

- К задаче обязательно привязан один "заказчик";
- К задаче может быть привязан один исполнитель;
- К задаче может быть привязано несколько "прикрепленных файлов";
- К задаче может быть привязан один город;
- К задаче обязательно привязана одна категория;
- К задаче может быть привязано несколько откликов;
- К задаче может быть привязан один отзыв;
- К задаче может быть привязано несколько уведомлений;
- К задаче может быть привязан чат между исполнителем и заказчиком.

## Сущность "пользователь"

### Свойства:  имя, почта, адрес, дата рождения, информация "о себе", аватар, настройки уведомлений, видимость профиля, контакты, количество просмотров, дата когда последний раз был online, город

### Связи

- К пользователю может быть привязано несколько категорий (специализаций);
- К пользователю может быть привязано несколько фото работ;
- К пользователю может быть привязано несколько избранных исполнителей;
- К пользователю может быть привязано несколько задач;
- К пользователю обязательно привязан один город.

## Сущность "категория"

### Свойства: название

## Сущность "сообщение чата"

### Свойства:  автор сообщения, текст сообщения

### Связи

- Чат привязан к одной задаче;
- Автор собщения это пользователь (исполнитель  задачи или заказчик).

## Сущность "город"

### Свойства:  название

## Сущность "уведомление"

### Свойства:  тип уведомления, получатель, сообщение

### Связи

- Уведомление обязательно связано с одной задачей;
-  Получатель обязательно связан с одним пользователем.

## Сущность "отзыв"

### Свойства:  текст отзыва, оценка, дата отзыва, отклонен ли отзыв