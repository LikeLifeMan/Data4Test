# Data4Test

Сервер для генерации тестовых json данных

Построен с использованием библиотеки [Faker](https://github.com/fzaninotto/Faker). Поддерживает частичный набор форматтеров библиотеки.

## Установка

```sh
git clone https://github.com/LikeLifeMan/Data4Test.git

composer install
```

## Использование

Сервер поддерживает 2 вида запросов

#### Упрощенный запрос

```javascript
[GET] HOST/api/simple/{locale}/{count}?{params}
```

locale - локаль (ru_RU, en_US и т.д.)<br>
count - количество строк результата<br>
params - список полей и типов значений для заполнения

##### Пример

Запрос

```javascript
[GET] HOST/api/simple/ru_RU/5?uuid=uuid&email=email
```

Результат

```javascript
[
  {
    uuid: "6faccc41-b99f-3b16-b42d-8579510a3518",
    email: "renata57@kazakov.net"
  },
  {
    uuid: "841964f6-602b-3de6-9c7a-fee97b173009",
    email: "dandreeva@rambler.ru"
  },
  {
    uuid: "78c673b8-58ea-3d03-b51b-67b6dd221d22",
    email: "erik81@kozlov.org"
  },
  {
    uuid: "46b27134-5fe9-3820-9c25-f2d358ebc0c5",
    email: "zzukova@lukin.ru"
  },
  {
    uuid: "8adad109-460f-32b3-b916-c019a902650e",
    email: "nadezda.sarapov@rambler.ru"
  }
];
```

#### Запрос с шаблоном

```
[POST] HOST/api/template/{locale}
```

locale - локаль (ru_RU, en_US и т.д.)

Структура шаблона

```
[
  { "key":keyName,"val": value, "count": count },
  ...
]
```

key - наименование поля результата
val - наименование форматтера (если поддерживается) или вложенный шаблон
count - счетчик для генерации результата (поддерживается только для объектов, где val является вложенным шаблоном)

Шаблон поддерживает вложенность

```
[
  { "key": "company", "val": "company" },
  {
    "key": "data",
    "val": [{ "key": "name", "val": "name" }, { "key": "jobTitle", "val": "jobTitle" }],
    "count": 3
  }
]
```

Результат

```
{
  "company": "Gutmann-Mosciski",
  "data": [
    {
      "name": "Bailee Krajcik",
      "jobTitle": "Precision Dyer"
    },
    {
      "name": "Joanny Rice",
      "jobTitle": "Ship Engineer"
    },
    {
      "name": "Gabriel Ondricka",
      "jobTitle": "Mapping Technician"
    }
  ],
}
```
