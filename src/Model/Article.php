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
}
