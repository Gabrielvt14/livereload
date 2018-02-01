<?php

// Chama Classe ViewRenderer que eu mesmo criei para rendereizar views
use SON\View\ViewRenderer;
// Chama REQUEST para fazer rotas de POST
use Symfony\Component\HttpFoundation\Request;

// Inicia a aplicação SIlex
$app = new Silex\Application();

// Cria container com o Pimple
// Container com configurações da view
$app['view.config'] = [
    'path_templates' => __DIR__ . '/../templates/'
];

// Container com configurações da view
$app['view.renderer'] = function() use($app) {
    $pathTemplates = $app['view.config']['path_templates'];
    return new ViewRenderer($pathTemplates);
};

// Rota raiz do sistema
//$app->get('/', function() {
//    return "Olá Silex";
//});

// Rota Hello World
//$app->get('/hello-world', function() {
//    return "Hello Wolrd!";
//});

// Rota Home
// Contem formulário para renderizar na tela
// __DIR__ . '/../templates/home.phtml'
$app->get('/home', function() use($app) {
    return $app['view.renderer']->render('home');
});

// Rota que recebe o formulario da rota HOME
// Contem resultado do formulario da rota HOME
// __DIR__ . '/../templates/get-name.phtml'
$app->post('/get-name/{param1}/{param2}', function(Request $request, $param1, $param2) use($app) {
    $name = $request->get('nome', 'sem nome');
    // Pega todos os parametros GET que foram passados
    // $data = $request->query->all();
    // Pega todos os parametros POST que foram passados
    // $data = $request->request->all();
    return $app['view.renderer']->render('get-name', [
        'name' => $name,
        'param1' => $param1,
        'param2' => $param2
    ]);
});

// Roda a aplicação
$app->run();