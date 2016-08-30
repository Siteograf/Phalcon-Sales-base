<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class SaleForm extends Form
{

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {

        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }

        $this->client_id =  $options['client_id'];

        $service_tid = new Select('service_tid', SaleType::find(), array(
            'using' => array('tid', 'name'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        ));
        $service_tid->setLabel('Type');
        $this->add($service_tid);

        $price_base = new Text("price_base");
        $price_base->setLabel('Цена для клиента');
        $this->add($price_base);

        $price_client_paid = new Text("price_client_paid");
        $price_client_paid->setLabel('Клиент заплатил');
        $this->add($price_client_paid);

        $partner_id = new Select('partner_id', SalePartner::find(), array(
            'using' => array('tid', 'name'),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class' => 'select2-single'
        ));
        $partner_id->setLabel('Партнер');
        $this->add($partner_id);

        $price_partner = new Text("price_partner");
        $price_partner->setLabel('Цена партнера');
        $this->add($price_partner);

        $price_partner_paid = new Text("price_partner_paid");
        $price_partner_paid->setLabel('Заплатили партнеру');
        $this->add($price_partner_paid);

        $date_expectation = new Text("date_expectation");
        $date_expectation->setLabel('Дата ожидания готовности');
        $this->add($date_expectation);



    }
}