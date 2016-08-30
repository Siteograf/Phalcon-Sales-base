<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    protected function initialize()
    {
        $this->tag->prependTitle('GRR | ');
        $this->view->setTemplateAfter('main');

        $this->assets->addJs('lib/jquery/jquery-3.1.0.min.js');

        // DataTable
        $this->assets->addJs('lib/DataTable/media/js/jquery.dataTables.min.js');
        $this->assets->addJs('lib/DataTable/media/js/dataTables.bootstrap4.min.js');
        $this->assets->addJs('lib/DataTable/extensions/FixedHeader/js/dataTables.fixedHeader.min.js');

        $this->assets->addCss('lib/DataTable/media/css/dataTables.bootstrap4.css');
        $this->assets->addCss('lib/DataTable/extensions/FixedHeader/css/fixedHeader.bootstrap4.css');

        $this->assets->addJs('lib/handlebars/handlebars-v4.0.5.js');

        $this->assets->addJs('lib/tableFixedHeader/table-fixed-header.js');

        $this->assets->addJs('js/jsnFastSearch.js');

    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1],
                'params' => $params
            )
        );
    }

    protected function destination($dest)
    {
        $uri = htmlspecialchars(pg_escape_string($dest));
        if ($uri) {
            $this->flash->success("$uri");
            $this->response->redirect("$uri");
            $this->view->disable();
        }
    }






}
