<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Response;


class NewsController
{
    public function list(): Response
    {

        return new Response('List', 'List!!');
    }

    #[Route("addition")]
    public function add(): Response
    {

        return new Response('Add', 'Add!!');
    }

    #[Route("home")]
    public function index(): Response
    {

        return new Response('Index', 'Index!!');
    }


}