# Подсчет бюджета на каждого клиента

Скрипт выполнен в рамках тестового задания.

Нужно написать функцию, которая будет принимать "дату от", "дату до" . Дата задается в формате timestamp. Она получает список всех сделок в аккаунте на статусе "Успешно реализовано", и циклом фильтрует сделки по дате закрытия. В подходящих суммирует бюджет. Результат функции — суммарный бюджет по таким сделкам.

Далее нужно пройтись по всем клиентам в Ядре и если их доступы в amoCRM актуальны, то просуммировать все суммарные бюджеты. Таким образом мы получим общую сумму закрытых сделок по всем нашим клиентам от какого-то времени до какого-то.

Итогом является PHP-скрипт с GET-параметрами c date_from и date_to, который отдает html-таблицу с тремя колонками: ID клиента в Ядре, название клиента, сумма его успешных сделок за период. А также отдельно конечную цифру — сумму по всем клиентам за период.

Получение списка клиентов нужно реализовать внутренней функцией, которая возвращает массив клиентов. Пока в качестве такого списка будет один клиент:
function getClients() {
    return [
        [
            ‘id’ => 1,
            ‘name’ => ‘intrdev’,
            ‘api’ => ‘’,
        ],
        [
            ‘id’ => 2,
            ‘name’ => ‘artedegrass0’,
            ‘api’ => ‘’,
        ],
    ];
}

Работу с amoCRM необходимо реализовать, используя внутреннее API платформы Yadro.

Проверить актуален доступ в amoCRM или нет можно с помощью метода /crm/account. Если данные возвращаются, то значит доступ есть.

SDK предоставлено компанией Интроверт. <br>
Документация и API-консоль платформы Yadro: https://bitbucket.org/mahatmaguru/intr-sdk-test/