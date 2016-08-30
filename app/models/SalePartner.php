<?php

use Phalcon\Mvc\Model;

/**
 * Terms
 */
class SalePartner extends Model
{
    /**
     * @var integer
     */
    public $tid;
    /**
     * @var integer
     */
    public $vid;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;
    /**
     * @var integer
     */
    public $weight;



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