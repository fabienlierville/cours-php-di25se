<?php
namespace src\Controller;

use src\Model\Article;
use src\Model\BDD;


class AdminArticleController extends AbstractController{

    public function list(){
        $articles = Article::SqlGetAll();
        return $this->twig->render('admin/article/list.html.twig', [
            'articles' => $articles
        ]);
    }

    public function add()
    {
        $article = new Article();
        $article->setTitre($_POST['Titre']);
        $article->setDescription($_POST['Description']);
        $article->setAuteur($_POST['Auteur']);
        $article->setDatePublication(new \DateTime($_POST['DatePublication']));

        Article::SqlAdd($article);

        return $this->twig->render('admin/article/add.html.twig');
    }
    public function fixtures(){
        $requete = BDD::getInstance()->prepare("TRUNCATE TABLE articles")->execute();
        $arrayAuteur = ["Thomas","Timéo","Alexandre","Antoine","Laura"];
        $arrayTitre = ["PHP En force", "React JS une valeur sure", "C# toujours au top", "Java en baisse"];
        $dateAjout = new \DateTime();

        for($i=1;$i<=200;$i++) {
            $dateAjout->modify("+1 day");
            shuffle($arrayAuteur);
            shuffle($arrayTitre);
            $article = new Article();
            $article->setTitre($arrayTitre[0])
                ->setDescription("Zypher est un langage de programmation moderne conçu pour offrir une expérience de développement puissante et flexible. Avec une syntaxe claire et concise, Zypher permet aux développeurs de créer des applications robustes et efficaces dans divers domaines, allant de l'informatique embarquée à la programmation web")
                ->setAuteur($arrayAuteur[0])
                ->setDatePublication($dateAjout);
            Article::SqlAdd($article);
        }
        header('location: /?controller=AdminArticle&action=list ');
    }

}