<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Sale extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $service_tid;

    /**
     * @var string
     */
    public $description;


    /**
     * @var integer
     */
    public $client_id;


    /**
     * @var integer
     */
    public $position;


    /**
     * @var integer
     * Цена для клиента
     */
    public $price_base;

    /**
     * @var integer
     * Клиент заплатил
     */
    public $price_client_paid;

    /**
     * @var integer
     * Долг клиента
     */
    public $price_client_debt;

    /**
     * @var integer
     * Цена партнера
     */
    public $price_partner;

    /**
     * @var integer
     * Заплатили партнеру
     */
    public $price_partner_paid;

    /**
     * @var integer
     * Долг перед партнером
     */
    public $price_partner_debt;

    /**
     * @var integer
     * Прибыль планируемая
     */
    public $price_profit_plan;

    /**
     * @var integer
     * Прибыль фактическая
     */
    public $price_profit_fact;

    /**
     * @var integer
     * Партнер id
     */
    public $partner_id;

    /**
     * @var string
     * Дата ожидания готовности
     */
    public $date_expectation;

    /**
     * @var string
     * Дата начала
     */
    public $date_start;

    /**
     * @var string
     * Дата готовности
     */
    public $date_done;

    /**
     * @var string
     * Дата оплаты партнеру
     */
    public $date_partner_paid;

    /**
     * @var string
     * Дата уведомления клиента
     */
    public $date_client_notice;

    /**
     * @var string
     * Дата погашения долга клиентом
     */
    public $date_client_debt_satisfaction;

    /**
     * @var string
     * Дата получения клиентом услуги
     */
    public $date_client_service_get;

    /**
     * @var integer
     * User отправил услугу в работу
     */
    public $uid_start;

    /**
     * @var integer
     * User получил готовую услугу
     */
    public $uid_done;

    /**
     * @var integer
     * User оплатил партеру
     */
    public $uid_partner_paid;

    /**
     * @var integer
     * User сообщил клиенту о готовности услуги
     */
    public $uid_client_notice;

    /**
     * @var integer
     * User получил долг от клиента
     */
    public $uid_client_debt_satisfaction;

    /**
     * @var integer
     * User передал услугу клиенту
     */
    public $uid_client_service_get;

    /**
     * @var integer
     * User создал услугу
     */
    public $uid_create;

    /**
     * @var integer
     *
     */
    public $created;

    /**
     * @var integer
     *
     */
    public $changed;


    /**
     * @var integer
     *
     */
    public $status;

    public function beforeSave()
    {
        // ДК = Ц - КЗ
        $this->price_client_debt = $this->price_base - $this->price_client_paid;
        // ДПП = ЦП - ЗП
        $this->price_partner_debt = $this->price_partner - $this->price_partner_paid;
        // ПП = Ц - ЦП
        $this->price_profit_plan = $this->price_base - $this->price_partner;
        // ПФ = КЗ - ЗП
        $this->price_profit_fact = $this->price_client_paid - $this->price_partner_paid;

    }

    /**
     * Products initializer
     */
    public function initialize()
    {
        $this->belongsTo(
            'service_tid', // Поле в текущей модели
            'SaleType', // Модель на которую ссылаемся
            'tid', //Поле в той модели
            array('reusable' => true)
        );

        $this->belongsTo(
            'client_id', // Поле в текущей модели
            'Client', // Модель на которую ссылаемся
            'id', //Поле в той модели
            array('reusable' => true)
        );

        $this->belongsTo(
            'partner_id', // Поле в текущей модели
            'SalePartner', // Модель на которую ссылаемся
            'tid', //Поле в той модели
            array('reusable' => true)
        );
    }

    /**
     * Returns a human representation of 'active'
     *
     * @return string
     */
//    public function getActiveDetail()
//    {
//        if ($this->status == 'Y') {
//            return 'Yes';
//        }
//        return 'No';
//    }

}