<?php
namespace src\Controller;

use src\Model\Article;

class ArticleController extends AbstractController{
    public function index(){
        $articles = Article::SqlGetLast(5);
        return $this->twig->render('front/index.html.twig', [
            'articles' => $articles
        ]);
    }
    public function show($id){
        $article = Article::SqlGetById($id);
        return $this->twig->render('front/article/show.html.twig', [
            'article' => $article
        ]);
    }



}