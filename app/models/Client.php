<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Client extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $changed;

    /**
     * @var string
     */
    public $uid;

    /**
     * @var string
     */
    public $status;



    /**
     * Products initializer
     */
//    public function initialize()
//    {
//        $this->belongsTo('product_types_id', 'ProductTypes', 'id', array(
//            'reusable' => true
//        ));
//    }

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