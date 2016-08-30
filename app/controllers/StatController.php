<?php


class StatController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('1');
        parent::initialize();

        $this->assets
            ->addJs('lib/Highcharts/js/highcharts.js')
            ->addJs('js/highcharts/highcharts.run.js');

        // библиотека работы с датами и временем
        $this->assets->addJs('lib/moment/moment-with-locales.min.js');
    }

    // Статистика - Продажи по месяцам
    public function statJsnSalesAction()
    {
        $statMode = $this->request->getPost("statMode");

        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');


        if ($statMode == 'month') {
            $sales = $this->modelsManager->executeQuery("
                    SELECT
                        FROM_UNIXTIME(created, '%Y.%m') AS period,
                        SUM(price_client_paid)     AS client_paid,
                        SUM(price_profit_plan)     AS profit_plan,
                        SUM(price_profit_fact)     AS profit_fact,
                        count(id)                    AS sale_cnt
                    FROM Sale
                    GROUP BY period
                    ORDER BY period ASC
                    "
            );
        }

        if ($statMode == 'year') {
            $sales = $this->modelsManager->executeQuery("
                    SELECT
                        FROM_UNIXTIME(created, '%Y') AS period,
                        SUM(price_client_paid)     AS client_paid,
                        SUM(price_profit_plan)     AS profit_plan,
                        SUM(price_profit_fact)     AS profit_fact,
                        count(id)                    AS sale_cnt
                    FROM Sale
                    GROUP BY period
                    ORDER BY period ASC
                    "
            );
        }


        if ($statMode == 'period') {
            // Получаем значения старта и финиша
            $dateStart = $this->request->getPost("dateStart");
            $dateFinish = $this->request->getPost("dateFinish");

            // Запрос с точностью до дня
            $sales = $this->modelsManager->executeQuery("
                    SELECT
                        FROM_UNIXTIME(created, '%Y.%m.%d') AS period,
                        SUM(price_client_paid)     AS client_paid,
                        SUM(price_profit_plan)     AS profit_plan,
                        SUM(price_profit_fact)     AS profit_fact,
                        count(id)                  AS sale_cnt
                    FROM Sale
                    WHERE
                      FROM_UNIXTIME(created, '%Y.%m.%d') >= :dateStart: AND
                      FROM_UNIXTIME(created, '%Y.%m.%d') <= :dateFinish:
                    GROUP BY period
                    ORDER BY period ASC
                    ",
                [
                    'dateStart' => "$dateStart",
                    'dateFinish' => "$dateFinish",
                ]
            );
        }


        $output = [];

        foreach ($sales as $field) {
            $output['period'][] = $field->period;
            $output['client_paid'][] = intval($field->client_paid);
            $output['profit_plan'][] = intval($field->profit_plan);
            $output['profit_fact'][] = intval($field->profit_fact);
            $output['sale_cnt'][] = intval($field->sale_cnt);
        }

        echo json_encode($output);
        die;
    }


    public function statMonthAction()
    {

    }

    public function statYearAction()
    {

    }

    public function statPeriodAction($dateStart, $dateFinish)
    {

        // подключаем выпадающий календарь
        $this->assets->addCss('lib/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
        $this->assets->addJs('lib/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
        // Запускаем скрипты для текущей страницы
        $this->assets->addJs('js/datepicker/bootstrap-datepicker.stat.run.js');

        // Отправляем данные в шаблон
        $this->view->dateStart = $dateStart;
        $this->view->dateFinish = $dateFinish;

    }

    // Статика регистраций пользователей по месяцам
    public function statUsersMonthsAction()
    {
        if (empty($authUser = $this->auth->getUser())) {
            return $this->auth->notAccess();
        } else {
            if ($authUser->rolesId != 1) {
                return $this->auth->notAccess();
            } else {

                // Скрипт построения графика
                $this->assets
                    ->addJs('library/сhartjs/Chart.min.js')
                    ->addJs('js/chartJS/chart.run.js');
                // библиотека работы с датами и временем
                $this->assets->addJs('library/moment/moment-with-locales.min.js');
                // подключаем выпадающий календарь
                // $this->assets->addCss('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.ru.js');
                // Запускаем скрипты для текущей страницы
                $this->assets->addJs('js/datepicker/bootstrap-datepicker.stat.run.js');

                $result = $this->db->query("
                                            SELECT YEAR(createdAt) 'year', MONTH(createdAt) 'month', COUNT(id) cnt
                                            FROM users
                                            WHERE YEAR(createdAt) is not null
                                            GROUP BY YEAR(createdAt), MONTH(createdAt)
                                            ");

                // $data = $result->fetchAll();

                while ($row = $result->fetchArray()) {
                    foreach ($row as $key => $value) {
                        $new_array[$row['year'] . '-' . $row['month']] = $row['cnt'];
                    }
                }

                // $this->view->r = $data;
                $this->view->dta = $new_array;

            }
        }
    }

    // Передает в основной экшн даты
    public function statUsersDaysDefaultAction()
    {
        // Сегодняшняя дата
        $dateFinishDefault = date('d.m.Y');

        // На сколько дней назад будет показано
        $daysAgo = 30;
        // Получаем дату в прошлом
        $dateStartDefault = date("d.m.Y", strtotime("-$daysAgo days")); // 10.01.2016';

        $redirectUrl = "/admin/stat/user/days/" . $dateStartDefault . "/" . $dateFinishDefault;

        $this->response->redirect("$redirectUrl");
        $this->flash->notice("Показаны зарегистрировавшиеся за последние $daysAgo дней");
        $this->view->disable();
    }

    // Статистика пользователей по дням, принимает параметры из URL
    public function statUsersDaysAction($dateStart, $dateFinish)
    {
        if (empty($authUser = $this->auth->getUser())) {
            return $this->auth->notAccess();
        } else {
            if ($authUser->rolesId != 1) {
                return $this->auth->notAccess();
            } else {

                // Скрипт построения графика
                $this->assets
                    ->addJs('library/сhartjs/Chart.min.js')
                    ->addJs('js/chartJS/chart.run.js');
                // библиотека работы с датами и временем
                $this->assets->addJs('library/moment/moment-with-locales.min.js');
                // подключаем выпадающий календарь
                // $this->assets->addCss('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.ru.js');
                // Запускаем скрипты для текущей страницы
                $this->assets->addJs('js/datepicker/bootstrap-datepicker.stat.run.js');


                // Отправляем данные в шаблон
                $this->view->dateStart = $dateStart;
                $this->view->dateFinish = $dateFinish;

                // Переформатиуем получаемую дату в DATETIME для поиска в бд
                // Дата приходит в 31.12.2015 должна уйти в 2015-12-31
                $periodDateStart = date('Y-m-d', strtotime($dateStart));
                $periodDateFinish = date('Y-m-d', strtotime($dateFinish));

                // Для тестирования в базе
                // $periodDateStart = '2015-12-31';
                // $periodDateFinish = '2015-12-31';

                $result = $this->db->query("
                    SELECT
                        YEAR(createdAt) 'year',
                        MONTH(createdAt) 'month',
                        DAY(createdAt) 'day',
                        COUNT(id) cnt
                    FROM users
                    WHERE YEAR(createdAt) is not null AND
                          DATE(createdAt) >= :periodDateStart AND
                          DATE(createdAt) <= :periodDateFinish
                    GROUP BY YEAR(createdAt), MONTH(createdAt), DAY(createdAt)
                    ORDER BY id", array(
                    'periodDateStart' => $periodDateStart,
                    'periodDateFinish' => $periodDateFinish,
                ));

                // $data = $result->fetchAll();

                while ($row = $result->fetchArray()) {
                    foreach ($row as $key => $value) {
                        $new_array[$row['year'] . '-' . $row['month'] . '-' . $row['day']] = $row['cnt'];
                    }
                }

                $this->view->dta = $new_array;

            }
        }
    }


    // СТАТИСТИКА СОЗДАНИЯ ВИРТУАЛЬНЫХ S-ПОЛЬЗОВАТЕЛЕЙ
    public function statUsersSlaveAction()
    {
        if (empty($authUser = $this->auth->getUser())) {
            return $this->auth->notAccess();
        } else {
            if ($authUser->rolesId != 1) {
                return $this->auth->notAccess();
            } else {

                // Скрипт построения графика
                $this->assets
                    ->addJs('library/сhartjs/Chart.min.js')
                    ->addJs('js/chartJS/chart.run.js');
                // библиотека работы с датами и временем
                $this->assets->addJs('library/moment/moment-with-locales.min.js');
                // подключаем выпадающий календарь
                // $this->assets->addCss('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.ru.js');
                // Запускаем скрипты для текущей страницы
                $this->assets->addJs('js/datepicker/bootstrap-datepicker.stat.run.js');

                $result = $this->db->query("
                                            SELECT
                                              YEAR(createdAt)  'year',
                                              MONTH(createdAt) 'month',
                                              COUNT(users.id) cnt
                                            FROM profiles
                                              INNER JOIN users ON users.id = profiles.usersId
                                            WHERE mainSlaveRegular = 'S' AND YEAR(users.createdAt) IS NOT NULL
                                            GROUP BY YEAR(createdAt), MONTH(createdAt);
                                            ");

                // $data = $result->fetchAll();

                while ($row = $result->fetchArray()) {
                    foreach ($row as $key => $value) {
                        $new_array[$row['year'] . '-' . $row['month']] = $row['cnt'];
                    }
                }

                // $this->view->r = $data;
                $this->view->dta = $new_array;

            }
        }
    }

    // Статистика по сообщениям
    public function statMsgDefaultAction()
    {
        // Сегодняшняя дата
        $dateFinishDefault = date('d.m.Y');

        // На сколько дней назад будет показано
        $daysAgo = 90;

        // Получаем дату в прошлом
        $dateStartDefault = date("d.m.Y", strtotime("-$daysAgo days")); // 10.01.2016';

        // Составляем URL
        $redirectUrl = "/admin/stat/msg/" . $dateStartDefault . "/" . $dateFinishDefault;

        $this->response->redirect("$redirectUrl");
        $this->flash->notice("Показаны сообщения за последние $daysAgo дней");
        $this->view->disable();
    }

    // Статистика сообщений
    public function statMsgAction($dateStart, $dateFinish)
    {
        if (empty($authUser = $this->auth->getUser())) {
            return $this->auth->notAccess();
        } else {
            if ($authUser->rolesId != 1) {
                return $this->auth->notAccess();
            } else {

                // Скрипт построения графика
                $this->assets
                    ->addJs('library/сhartjs/Chart.min.js')
                    ->addJs('js/chartJS/chart.run.js');
                // библиотека работы с датами и временем
                $this->assets->addJs('library/moment/moment-with-locales.min.js');
                // подключаем выпадающий календарь
                // $this->assets->addCss('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
                $this->assets->addJs('library/bootstrap-datetimepicker/bootstrap-datetimepicker.ru.js');
                // Запускаем скрипты для текущей страницы
                $this->assets->addJs('js/datepicker/bootstrap-datepicker.stat.run.js');

                // Отправляем данные в шаблон
                $this->view->dateStart = $dateStart;
                $this->view->dateFinish = $dateFinish;

                // Переформатиуем получаемую дату в DATETIME для поиска в бд
                // Дата приходит в 31.12.2015 должна уйти в 2015-12-31
                $periodDateStart = date('Y-m-d', strtotime($dateStart));
                $periodDateFinish = date('Y-m-d', strtotime($dateFinish));

                // Для тестирования в базе
                // $periodDateStart = '2015-12-31';
                // $periodDateFinish = '2015-12-31';

                $result = $this->db->query("
                    SELECT
                        YEAR(createdAt) 'year',
                        MONTH(createdAt) 'month',
                        DAY(createdAt) 'day',
                        COUNT(id) cnt
                    FROM messages
                    WHERE YEAR(createdAt) is not null
                          AND
                          DATE(createdAt) >= :periodDateStart AND
                          DATE(createdAt) <= :periodDateFinish
                    GROUP BY YEAR(createdAt), MONTH(createdAt), DAY(createdAt)
                    ORDER BY id", array(
                    'periodDateStart' => $periodDateStart,
                    'periodDateFinish' => $periodDateFinish,
                ));

                // $data = $result->fetchAll();

                while ($row = $result->fetchArray()) {
                    foreach ($row as $key => $value) {
                        $new_array[$row['year'] . '-' . $row['month'] . '-' . $row['day']] = $row['cnt'];
                    }
                }

                $this->view->dta = $new_array;

            }
        }
    }
}
