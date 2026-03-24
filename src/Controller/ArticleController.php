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

    public function search(){
        if(isset($_POST['Search']))
        {
            $articles = Article::SqlSearch($_POST['Search']);
            return $this->twig->render("front/article/search.html.twig",[
                "articles" => $articles,
                "keyword" => $_POST['Search']
            ]);
        }

        Header("location: / "); //rien dans la recherche retour à l’accueil
    }


}