<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ClientController extends ControllerBase
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

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Client", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [
            "order" => "id DESC"
        ];

//        if ($this->persistent->searchParams) {
//             $parameters = $this->persistent->searchParams;
//        }

        $clients = Client::find($parameters);
        if (count($clients) == 0) {
            $this->flash->notice("The search did not find any products");
            return $this->forward("client/index");
        }

        $paginator = new Paginator(array(
            "data" => $clients,
            "limit" => 20,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }



    public function pageAction($id)
    {
        $this->session->conditions = null;

        // Select 2
        $this->assets->addJs('lib/select2/dist/js/select2.full.min.js');
        $this->assets->addJs('js/select2/select2.run.js');
        $this->assets->addCss('lib/select2/dist/css/select2.min.css');
        $this->assets->addCss('lib/select2-bootstrap-theme/dist/select2-bootstrap.min.css');

        // formValidation
        $this->assets->addJs('lib/formValidation/formValidation.min.js');
        $this->assets->addJs('lib/formValidation/ru_RU.min.js');
        $this->assets->addJs('lib/formValidation/bootstrap.min.js');
        $this->assets->addJs('js/formValidation/formValidation.sale.run.js');
        $this->assets->addCss('lib/formValidation/formValidation.min.css');

        $this->assets->addJs('js/dataTable.run.js');
        $this->assets->addJs('js/ajaxFlag.js');

        // Get client data
        $client = Client::findFirstById($id);
        if (!$client) {
            $this->flash->error("Client was not found");
            return $this->forward("client/index");
        }

        $this->view->client = $client;

        // Get sales of current client
        $sales = Sale::find([
            "client_id = {$id}",
            "order" => "id ASC"
        ]);

//        print "<pre>";
//        print_r($sales->toArray());
//        print "</pre>";


        $this->view->sales = $sales;

        $this->view->form = new SaleForm(null, array('edit' => true, 'client_id' => $id));

    }

    /**
     * Shows the form to create a new product
     */
    public function newAction()
    {
        $this->view->form = new ClientForm(null, array('edit' => true));
    }


    public function jsnFastSearchAction()
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');


        if ($this->request->isPost()) {
            $searchString = $this->request->getPost("search");
        }

        $clients = Client::find([
            "limit" => 30,
            "order" => "id DESC",
            "conditions" => "name LIKE :name:",
            "bind" => ['name' => '%' . $searchString . '%']
        ]);

        $output = [];

        foreach ($clients as $field) {
            $sale['id'] = $field->id;
            $sale['name'] = $field->name;
            $output[] = $sale;
        }

        echo json_encode($output);
        die;
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("client/index");
        }

        $form = new ClientForm;
        $client = new Client();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $client)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('client/new');
        }

        if ($client->save() == false) {
            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('clients/new');
        }

        $form->clear();

        $this->flash->success("Client was created successfully $client->id");

        $this->response->redirect("client/page/$client->id");
        $this->view->disable();



    }


    /**
     * Edits a client based on its id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $product = Client::findFirstById($id);
            if (!$product) {
                $this->flash->error("Client was not found");
                return $this->forward("client/index");
            }

            $this->view->form = new ClientForm($product, array('edit' => true));
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
            return $this->forward("client/index");
        }

        $id = $this->request->getPost("id", "int");

        $product = Client::findFirstById($id);

        if (!$product) {
            $this->flash->error("Product does not exist");
            return $this->forward("client/index");
        }

        $form = new ClientForm;
        $this->view->form = $form;

        $data = $this->request->getPost();

        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('client/edit/' . $id);
        }

        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('client/edit/' . $id);
        }

        $form->clear();

        $this->flash->success("Client was updated successfully");
        return $this->forward("client/index");
    }

    /**
     *
     */
    public function addSaleAction($id)
    {

    }


}