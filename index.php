<h1>Coucou</h1>
<?php
$a = false;
$b = 12;
$c = 12.5;
$d = "Ceci est une chaine de caractère";
/*
echo "Vous avez $b €";
echo 'Vous avez $b €';
echo 'Vous avez '.$b.' €';
*/
// Ma méthode préférée pour afficher une valeur
echo "Vous avez {$b} €";

// Tableau
$arrayHomme = array("Brice", "Gael","Theo", "Lucas");
$arrayFemmee = ["Marion","Sylvie","Justine","Isabelle"];

echo $arrayHomme[0];
$arrayHomme[] = "Xavier";
var_dump($arrayHomme);

//Tableau associatif
$arrayFruits = [
  "F" => "Fraise",
  "A" => "Abricot",
  "P" => "Pomme"
];
echo "<p> Le fruit F = {$arrayFruits["F"]}</p>";

foreach($arrayFruits as $key => $fruit){
    echo ("<p>L'index {$key} correspond  au fruit {$fruit}</p>");
};
//EXO
$prenomsNote = [
        "Brice" => "C",
        "Julie" => "B",
        "Aegir" => "D",
        "Emilie" => "A"
];
echo "<ul>";
foreach($prenomsNote as $prenom => $note){
    echo "<li>{$prenom} a obtenu la note de {$note}</li>";
}
echo "</ul>";
 //Tableau MultiDimension
$achats = [
    "10:15" => [
        "Prenom" => "Nathan",
        "Prix" => 680,
        "Panier" => [
              "Fruits" => ["Fraise","Framboise","¨Pomme"],
            "Legumes" => ["Salade","Endive"]
        ]
    ],
        "10:30" => [
                "Prenom" => "Léo",
                "Prix" => 156,
                "Panier" => [
                        "Fruits" => ["Banane","Kiwi"],
                        "Legumes" => ["Tomate","Oignon"]
                ]
        ],
        "11:02" => [
                "Prenom" => "Gael",
                "Prix" => 85,
                "Panier" => [
                        "Fruits" => ["Pêche","Orange","¨Litchi"],
                        "Legumes" => ["Epinard","Carottes"]
                ]
        ],
        "13:53" => [
                "Prenom" => "Emmanuelle",
                "Prix" => 15000,
                "Panier" => [
                        "Fruits" => ["Pomme","Poire","¨Melon"],
                        "Legumes" => ["Carottes","Poireau"]
                ]
        ],
];

var_dump($achats);
//
$bibliotheque = [
        "ABC1" => ["Nom" => "Notre dame de Paris", "Page" => 655, "Année"=> 1831 ]
    ,"DEF2" => ["Nom" => "Les misérables", "Page" => 543, "Année"=> 1962 ]
    ,"GHI3" => ["Nom" => "Les 3 mousquetaires", "Page" => 389, "Année"=> 1920 ]
    , "JKL4" => ["Nom" => "50 nuances de Grey", "Page" => 224, "Année"=> 2010 ]
];
$ca = 0;
echo("<ul>");
foreach($achats as $horaire=>$achat){
    $ca = $ca + $achat["Prix"];
    echo "<li>";
    echo "Voici le pranier de {$achat["Prenom"]}  qui a dépensé {$achat["Prix"]}€ ";
        echo "<ul>";
        echo "<li> FRUITS : ";
            foreach($achat["Panier"]["Fruits"] as $fruit){
                echo "{$fruit}, ";
            }
        echo "</li>";
        echo "<li> LEGUMES : ";
        foreach($achat["Panier"]["Legumes"] as $legume){
            echo "{$legume}, ";
        }
        echo "</li>";
        echo "</ul>";
    echo "</li>";
}
echo("</ul>");
echo "<p>Le chiffre d'affaire est de {$ca}€</p>";

// Structures conditionnelles
$boolean = false;
$age = 10;
$ville = "Lille";
if($boolean){
    echo "<p>Boolean est à true</p>";
}elseif($age >= 13 AND ($ville == "Rouen" OR $ville == "Lille")){
    echo "<p>Supérieur ou égal à 13 ans et habite Rouen ou Lille</p>";
}else{
    echo "<p>Rien de tout ça</p>";
}











;





$nbPages = 0;
foreach ($bibliotheque as $isbn => $livre) {
    $nbPages = $nbPages + $livre["Page"];
}
echo "<p>Nombre de page total = {$nbPages}</p>";
$moyPage = $nbPages / count($bibliotheque);
echo "<p>Moyenne = {$moyPage}</p>";
$diffPage = $bibliotheque["ABC1"]["Page"] - $bibliotheque["JKL4"]["Page"];
echo "<p>Différence = {$diffPage}</p>";
// Fonctions
function parler(string $prenom,int $age) :string{
    $phrase = "Bonjour {$prenom} comment ça va ?";
    return $phrase;
}
echo parler(age:52,prenom:"Gérard");