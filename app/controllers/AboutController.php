<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AboutController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('About us');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->session->conditions = null;
        $numberPage = 1;
        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $products = Products::find($parameters);


        $paginator = new Paginator(array(
            "data"  => $products,
            "limit" => 3,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();

    }
}
