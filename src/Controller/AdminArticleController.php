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
        if($_POST){
            $sqlRepository = null;
            $nomImage = null;

            if(!empty($_FILES['Image']['name'])){
                //Récupération du type mime de fichier
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($_FILES['Image']['tmp_name']);
                $allowedMimeTypes = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');

                if(in_array($mimeType, $allowedMimeTypes)){
                    //Répertoire
                    $dateNow = new \DateTime();
                    $sqlRepository = $dateNow->format('Y/m');
                    $repository = "./uploads/images/".$sqlRepository;
                    if(!is_dir($repository)){
                        mkdir($repository, 0777, true);
                    }
                    //Nom de l'image
                    $extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
                    //Le fichier est il autorisé ?
                    $nomImage = md5(uniqid()) . '.' . $extension;
                    //Envoi du fichier
                    move_uploaded_file($_FILES['Image']['tmp_name'], $repository . '/' . $nomImage);
                }
            }

            $article = new Article();
            $article->setTitre($_POST['Titre']);
            $article->setDescription($_POST['Description']);
            $article->setAuteur($_POST['Auteur']);
            $article->setDatePublication(new \DateTime($_POST['DatePublication']));
            $article->setImageRepository($sqlRepository);
            $article->setImageFilename($nomImage);

            Article::SqlAdd($article);
            header('Location:/?controller=AdminArticle&action=list');
        }


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

    public function show($id){
        $article = Article::SqlGetById($id);
        return $this->twig->render('admin/article/show.html.twig', [
            'article' => $article
        ]);
    }

    public function edit($id)
    {
        $article = Article::SqlGetById($id);

        if($_POST){
            $sqlRepository = $article->getImageRepository();
            $nomImage = $article->getImageFilename();

            if(!empty($_FILES['Image']['name'])){
                //Récupération du type mime de fichier
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($_FILES['Image']['tmp_name']);
                $allowedMimeTypes = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');

                if(in_array($mimeType, $allowedMimeTypes)){
                    //Répertoire
                    $dateNow = new \DateTime();
                    $sqlRepository = $dateNow->format('Y/m');
                    $repository = "./uploads/images/".$sqlRepository;
                    if(!is_dir($repository)){
                        mkdir($repository, 0777, true);
                    }
                    //Nom de l'image
                    $extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
                    //Le fichier est il autorisé ?
                    $nomImage = md5(uniqid()) . '.' . $extension;
                    //Envoi du fichier
                    move_uploaded_file($_FILES['Image']['tmp_name'], $repository . '/' . $nomImage);
                }
            }

            //$article = new Article();
            $article->setTitre($_POST['Titre']);
            $article->setDescription($_POST['Description']);
            $article->setAuteur($_POST['Auteur']);
            $article->setDatePublication(new \DateTime($_POST['DatePublication']));
            $article->setImageRepository($sqlRepository);
            $article->setImageFilename($nomImage);

            Article::SqlUpdate($article);
            header('Location:/?controller=AdminArticle&action=show&param='.$article->getId());
        }


        return $this->twig->render('admin/article/edit.html.twig',[
            'article' => $article
        ]);
    }
}