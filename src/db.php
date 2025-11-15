<?php
// src/db.php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use MongoDB\Client;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$uri = $_ENV['MONGODB_URI'] ?? 'mongodb://127.0.0.1:27017';
$dbName = $_ENV['MONGODB_DB'] ?? 'school_db';

$client = new Client($uri, [], ['typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]);
$db = $client->selectDatabase($dbName);
