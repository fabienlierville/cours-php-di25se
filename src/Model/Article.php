<?php
namespace src\Model;
use PDO;

class Article {
    private ?int $Id = null;
    private ?string $Titre = null;
    private ?string $Description = null;
    private ?string $Auteur = null;
    private ?\DateTime $DatePublication = null;
    private ?string $ImageRepository = null;
    private ?string $ImageFilename = null;

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function setId(?int $Id): Article
    {
        $this->Id = $Id;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(?string $Titre): Article
    {
        $this->Titre = $Titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): Article
    {
        $this->Description = $Description;
        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(?string $Auteur): Article
    {
        $this->Auteur = $Auteur;
        return $this;
    }

    public function getDatePublication(): ?\DateTime
    {
        return $this->DatePublication;
    }

    public function setDatePublication(?\DateTime $DatePublication): Article
    {
        $this->DatePublication = $DatePublication;
        return $this;
    }

    public function getImageRepository(): ?string
    {
        return $this->ImageRepository;
    }

    public function setImageRepository(?string $ImageRepository): Article
    {
        $this->ImageRepository = $ImageRepository;
        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->ImageFilename;
    }

    public function setImageFilename(?string $ImageFilename): Article
    {
        $this->ImageFilename = $ImageFilename;
        return $this;
    }

    public static function SqlGetAll(){
        $bdd = BDD::getInstance();
        $req = $bdd->prepare("SELECT * FROM articles ORDER BY Id Desc");
        $req->execute();
        $articles = $req->fetchAll(\PDO::FETCH_ASSOC);
        //Transformer mon tableau de tableau en tableau objet
        $articlesObj = [];
        foreach ($articles as $articleSQL){
            $article = new Article();
            $date = new \DateTime($articleSQL['DatePublication']);
            $article->setId($articleSQL['Id']);
            $article->setTitre($articleSQL['Titre']);
            $article->setDescription($articleSQL['Description']);
            $article->setAuteur($articleSQL['Auteur']);
            $article->setDatePublication($date);
            $article->setImageRepository($articleSQL['ImageRepository']);
            $article->setImageFilename($articleSQL['ImageFileName']);

            $articlesObj[] = $article;
        }

        return $articlesObj;
    }

    public static function SqlAdd(Article $article){
        $bdd = BDD::getInstance();
        $req = $bdd->prepare("INSERT INTO articles (Titre, Description, DatePublication, Auteur, ImageRepository, ImageFileName) VALUES (:Titre, :Description, :DatePublication, :Auteur, :ImageRepository, :ImageFileName)");
        $req->bindValue(':Titre', $article->getTitre());
        $req->bindValue(':Description', $article->getDescription());
        $req->bindValue(':DatePublication', $article->getDatePublication()->format('Y-m-d'));
        $req->bindValue(':Auteur', $article->getAuteur());
        $req->bindValue(':ImageRepository', $article->getImageRepository());
        $req->bindValue(':ImageFileName', $article->getImageFilename());
        $req->execute();
        return $bdd->lastInsertId();
    }

    public static function SqlGetById($id){
        $bdd = BDD::getInstance();
        $req = $bdd->prepare("SELECT * FROM articles WHERE Id = :id");
        $req->bindValue(':id', $id);
        $req->execute();
        $article = $req->fetch(\PDO::FETCH_ASSOC);
        $articleObj = new Article();
        $date = new \DateTime($article['DatePublication']);
        $articleObj->setId($article['Id']);
        $articleObj->setTitre($article['Titre']);
        $articleObj->setDescription($article['Description']);
        $articleObj->setAuteur($article['Auteur']);
        $articleObj->setDatePublication($date);
        $articleObj->setImageRepository($article['ImageRepository']);
        $articleObj->setImageFilename($article['ImageFileName']);
        return $articleObj;
    }

    public static function SqlUpdate(Article $article){
        $bdd = BDD::getInstance();
        $req = $bdd->prepare("UPDATE articles SET Titre=:Titre, Description=:Description, DatePublication=:DatePublication, Auteur=:Auteur, ImageRepository=:ImageRepository, ImageFileName=:ImageFileName WHERE Id=:Id");
        $req->bindValue(':Titre', $article->getTitre());
        $req->bindValue(':Description', $article->getDescription());
        $req->bindValue(':DatePublication', $article->getDatePublication()->format('Y-m-d'));
        $req->bindValue(':Auteur', $article->getAuteur());
        $req->bindValue(':ImageRepository', $article->getImageRepository());
        $req->bindValue(':ImageFileName', $article->getImageFilename());
        $req->bindValue(':Id', $article->getId());
        $req->execute();

    }

    public static function SqlDelete($id){
        $requete = BDD::getInstance()->prepare("DELETE FROM articles WHERE id = :id");
        $requete->bindValue(':id', $id);
        $requete->execute();

    }

    public static function SqlGetLast(int $nb)
    {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles ORDER BY Id DESC LIMIT :limit');
        $requete->bindValue("limit", $nb, \PDO::PARAM_INT);
        $requete->execute();

        $articlesSql = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $articlesObjet = [];
        foreach ($articlesSql as $articleSql){
            $article = new Article();
            $article->setTitre($articleSql["Titre"])
                ->setId($articleSql["Id"])
                ->setDescription($articleSql["Description"])
                ->setDatePublication(new \DateTime($articleSql["DatePublication"]))
                ->setAuteur($articleSql["Auteur"])
                ->setImageRepository($articleSql["ImageRepository"])
                ->setImageFileName($articleSql["ImageFileName"]);
            $articlesObjet[] = $article;
        }
        return $articlesObjet;


    }


    public static function SqlSearch(string $keyword) : array {
        $requete = BDD::getInstance()->prepare('SELECT * FROM articles WHERE Titre LIKE :keyword OR Description LIKE :keyword ORDER BY Id DESC');
        $requete->bindValue(':keyword','%'.$keyword.'%');
        $requete->execute();
        $articlesSql = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $articlesObjet = [];
        foreach ($articlesSql as $articleSql){
            $article = new Article();
            $article->setId($articleSql["Id"]);
            $article->setTitre($articleSql["Titre"]);
            $article->setDescription($articleSql["Description"]);
            $article->setDatePublication(new \DateTime($articleSql["DatePublication"]));
            $article->setAuteur($articleSql["Auteur"]);
            $article->setImageRepository($articleSql["ImageRepository"]);
            $article->setImageFileName($articleSql["ImageFileName"]);
            $articlesObjet[] = $article;
        }
        return $articlesObjet;
    }


}
