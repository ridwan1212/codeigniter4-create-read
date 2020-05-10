<?php

namespace App\Controllers;

use App\Models\Article_model;

class Article extends BaseController
{
    public function __construct()
    {
        helper(['form', 'date']);
    }

    public function index()
    {
        $article = new Article_model();

        $data['pageTitle'] = 'CI-4 | Article';

        // load table
        $data['table'] = $article->getList();

        // load view
        echo view('templates/header', $data);
        echo view('templates/topbar');
        echo view('article/index', $data);
        echo view('templates/footer');
    }

    public function newPost()
    {
        $data['pageTitle'] = 'Create a New Post';

        echo view('templates/header', $data);
        echo view('templates/topbar');
        echo view('article/newpost', $data);
        echo view('templates/footer');
    }

    public function create()
    {
        // load validation
        $validation = \Config\Services::validation();

        // load model
        $article = new Article_model();

        $data['pageTitle'] = 'Create a New Post';

        if ($validation->run($_POST, 'new') == false) {
            echo view('templates/header', $data);
            echo view('templates/topbar');
            echo '<div class="alert alert-danger" role="alert">' . $validation->listErrors() . '</div>';
            echo view('article/newpost', $data, $_POST);
            echo view('templates/footer');
        } else {
            $article->createNew();
            return $this->response->redirect(site_url('article'));
        }
    }
}
