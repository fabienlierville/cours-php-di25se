<?php
namespace src\Controller;

class ArticleController extends AbstractController{
    public function index(){

        return $this->twig->render("front/index.html.twig");
    }
}