<?php

class NewsController
{
    public function list():Response
    {

        return new Response('List','List!!');
    }
    public function add():Response
    {

        return new Response('Add','Add!!');
    }
    public function index():Response
    {

        return new Response('Index','Index!!');
    }


}