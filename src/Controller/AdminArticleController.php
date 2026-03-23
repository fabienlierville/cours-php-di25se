<?php
namespace src\Controller;

use src\Model\Article;

class AdminArticleController{

    public function list(){
        $articles = Article::SqlGetAll();
        echo'<h1>Admininistration des articles</h1>';
        var_dump($articles);
    }
}