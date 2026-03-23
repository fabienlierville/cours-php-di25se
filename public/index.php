<?php
// Autoloader de Classe
function chargerClasse($class){
    $ds = DIRECTORY_SEPARATOR;
    $dir= $_SERVER["DOCUMENT_ROOT"]."$ds..";
    //Remplacement des séparateurs Namespace
    $className = str_replace("\\", $ds, $class);
    $file = "{$dir}{$ds}{$className}.php";
    if(file_exists($file)){
        require_once $file;
    }
 }
 spl_autoload_register('chargerClasse');

//Routeur
$controller = (isset($_GET['controller'])) ? $_GET['controller'] : '';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$param = (isset($_GET['param'])) ? $_GET['param'] : '';

if($controller != ''){
    try {
        $class = "src\Controller\\".$controller."Controller";
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($class, $action)) {
                echo $controller->$action($param);
            }else { throw new Exception("Action {$action} does not exist in {$class}"); }
        }else { throw new Exception("Controller {$controller} does not exist"); }
    }
    catch(Exception $e) {
        // Penser à Gérer l’exception
        var_dump($e->getMessage());
    }
}else {
    //Route par défaut (/) ce controller sera fait plus tard dans le cadre de l’exercice Front Office
    $controller = new \src\Controller\ArticleController();
    echo $controller->index();
}
