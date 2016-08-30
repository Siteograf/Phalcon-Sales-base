<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class SaleController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('1');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->session->conditions = null;

        $numberPage = 1;
//        if ($this->request->isPost()) {
//            $query = Criteria::fromInput($this->di, "Sale", $this->request->getPost());
//            $this->persistent->searchParams = $query->getParams();
//        } else {
//            $numberPage = $this->request->getQuery("page", "int");
//        }

        $parameters = array(
            "order" => "id DESC"
        );
//        if ($this->persistent->searchParams) {
//            $parameters = $this->persistent->searchParams;
//        }

        $sales = Sale::find($parameters);
        if (count($sales) == 0) {
            $this->flash->notice("The search did not find any clients");
            return $this->forward("services/index");
        }

        $paginator = new Paginator(array(
            "data" => $sales,
            "limit" => 20,
            "page" => $numberPage,
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function startToPartnerAction()
    {
        $saleId = $this->request->getPost("saleId", 'striptags');

        $sale = Sale::findFirstById($saleId);

        $sale->date_start = time();

        if ($sale->save() == false) {
            foreach ($sale->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('sale/edit/' . $saleId);
        }

        // Forward to controller who will give JSON with updated values
        $this->dispatcher->forward(
            array(
                "action" => "jsnOneSale",
                "params" => [$saleId],
            )
        );


    }

    // Get info about one sale. It used to update one row in sales table
    public function jsnOneSaleAction($saleId)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        $sale = Sale::findFirstById($saleId);

        $oneSale['id'] = $sale->id;
        $oneSale['saleType'] = $sale->saleType->name;

        $oneSale['price_base'] = $sale->price_base;
        $oneSale['price_client_paid'] = $sale->price_client_paid;
        $oneSale['price_client_debt'] = $sale->price_client_debt;

        $oneSale['partner_name'] = $sale->salePartner->name;
        $oneSale['price_partner'] = $sale->price_partner;
        $oneSale['price_partner_paid'] = $sale->price_partner_paid;
        $oneSale['price_partner_debt'] = $sale->price_partner_debt;

        $oneSale['price_profit_plan'] = $sale->price_profit_plan;
        $oneSale['price_profit_fact'] = $sale->price_profit_plan;

        echo json_encode($oneSale);
        die;
    }

    public function jsnAction()
    {

        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        // Проверка наличия переменной сессии
        if ($this->session->has("searchString")) {
            // Получение значения
            $searchString = $this->session->get("searchString");
        }

        // Если зарпос не пустой
        if (strlen($searchString)) {

            $sales = $this->modelsManager->executeQuery("
                                                     SELECT * FROM sale
                                                     INNER JOIN client
                                                     ON sale.client_id = client.id
                                                     WHERE client.name LIKE :name:
                                                     ORDER BY sale.id DESC
                                                     ",
                ['name' => '%' . $searchString . '%']
            );
        } else {
            // При пустом запросе отдать последние созданные
            $sales = $this->modelsManager->executeQuery("
                                                     SELECT * FROM sale
                                                     INNER JOIN client
                                                     ON sale.client_id = client.id
                                                     ORDER BY sale.id DESC
                                                     LIMIT 50
                                                     ");
        }

        $output = [];

        foreach ($sales as $field) {

            $clientLabel = $field->client->id . ' ' . $field->client->name;

            $client[$clientLabel]['client']['client_id'] = $field->client->id;
            $client[$clientLabel]['client']['client_name'] = $field->client->name;
            $client[$clientLabel]['client']['client_phone'] = $field->client->phone;

            $sale = [];
            $sale['id'] = $field->sale->id;
            $sale['saleType'] = $field->sale->saleType->name;

            $sale['price_base'] = $field->sale->price_base;
            $sale['price_client_paid'] = $field->sale->price_client_paid;
            $sale['price_client_debt'] = $field->sale->price_client_debt;

            $sale['partner_name'] = $field->sale->salePartner->name;
            $sale['price_partner'] = $field->sale->price_partner;
            $sale['price_partner_paid'] = $field->sale->price_partner_paid;
            $sale['price_partner_debt'] = $field->sale->price_partner_debt;

            $sale['price_profit_plan'] = $field->sale->price_profit_plan;
            $sale['price_profit_fact'] = $field->sale->price_profit_plan;

            $client[$clientLabel]['sales'][] = $sale;

            $output['items'] = $client;

        }

        echo json_encode($output);
        die;
    }

    public function listAction()
    {
        $this->assets->addJs('js/saleList.js');

        $searchString = $this->request->getPost("search");
        $this->session->set("searchString", $searchString);
    }


    public function newAction()
    {
        $this->view->form = new SaleForm(null, array('edit' => true));
    }


    /**
     * Creates a new Sale
     */
    public function createAction($client_id)
    {
        if (!$this->request->isPost()) {
            return $this->forward("sale/index");
        }

        $form = new SaleForm();
        $sale = new Sale();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $sale)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('sale/new');
        }

        // Привязываем продажу к клиенту
        $sale->client_id = $client_id;

        if ($sale->save() == false) {
            foreach ($sale->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('sale/new');
        }

        $form->clear();

        $this->flash->success("Sale was created successfully");

        $this->response->redirect("/client/page/$client_id");
        $this->view->disable();
    }

    /**
     * Edits a sale based on its id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $sale = Sale::findFirstById($id);
            if (!$sale) {
                $this->flash->error("Client was not found");
                return $this->forward("sale/index");
            }

            $this->view->form = new SaleForm($sale, array('edit' => true, 'client_id' => $sale->client_id));
        }


    }


    /**
     * Saves current product in screen
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("sale/index");
        }

        $id = $this->request->getPost("id", "int");

        $sale = Sale::findFirstById($id);
        if (!$sale) {
            $this->flash->error("Sale does not exist");
            return $this->forward("sale/index");
        }

        $form = new SaleForm;
        $this->view->form = $form;

        $data = $this->request->getPost();

        if (!$form->isValid($data, $sale)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('sale/edit/' . $id);
        }

        if ($sale->save() == false) {
            foreach ($sale->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('sale/edit/' . $id);
        }

        $form->clear();

        $this->flash->success("Sale  $id was edited successfully");

        if ($sale->client_id) {
            $this->response->redirect("/client/page/$sale->client_id");
            $this->view->disable();
        }

    }

    /**
     * Deletes a product
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $sale = Sale::findFirstById($id);

        if (!$sale) {
            $this->flash->error("Sale was not found");
        }

        if (!$sale->delete()) {
            foreach ($sale->getMessages() as $message) {
                $this->flash->error($message);
            }

        }
        $this->flash->success("Sale $id was deleted successfully");

        $this->destination($this->request->getQuery("destination"));
    }

}

