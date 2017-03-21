<?php
namespace App\Controllers;

class Controller
{
    protected $app;
    protected $request;
    protected $db;
    protected $pdo;
    protected $usuario;

    public function __construct(\Slim\Slim $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->pdo = $app->pdo;
        $this->db = $app->db;
        $this->usuario = $app->usuario;
    }

    protected function render($template, $args = [])
    {
        $this->app->render($template, $args);
    }

    protected function renderHtml($template, $args = [])
    {
        return $this->app->view->render($template, $args);
    }

    protected function responseJsonSuccess(array $data = [])
    {
        $data['success'] = true;
        $this->responseJson($data);
    }

    protected function responseJsonError(array $data = [])
    {
        $data['success'] = false;
        $this->responseJson($data);
    }

    protected function responseJson(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        $this->app->stop();
    }
}
