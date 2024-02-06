<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Enable CORS
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'your_host',
    'database'  => 'your_database',
    'username'  => 'your_username',
    'password'  => 'your_password',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

class Note extends Model {
    protected $fillable = ['title', 'content'];
}

// Serve the HTML page
$app->get('/', function (Request $request, Response $response, $args) {
    $htmlContent = file_get_contents(__DIR__ . '/index.html'); // Adjust path as necessary
    $response->getBody()->write($htmlContent);
    return $response;
});

// API endpoint to create a note
$app->post('/notes', function (Request $request, Response $response, $args) {
    $body = json_decode($request->getBody()->getContents(), true);
    $note = Note::create([
        'title' => $body['title'],
        'content' => $body['content']
    ]);
    $response->getBody()->write(json_encode($note));
    return $response->withHeader('Content-Type', 'application/json');
});


// API endpoint to get all notes
$app->get('/notes', function (Request $request, Response $response, $args) {
    $notes = Note::all();
    $response->getBody()->write(json_encode($notes));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();
