<?php
namespace src\Controller;

use src\Model\Article;


class AdminArticleController extends AbstractController{

    public function list(){
        $articles = Article::SqlGetAll();
        return $this->twig->render('admin/article/list.html.twig', [
            'articles' => $articles
        ]);
    }
}