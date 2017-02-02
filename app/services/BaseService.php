<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \PDO;

abstract class BaseService {
  private $dbPrefix = 'frs_';
  protected $pdo;

  private function connect() {
    $config = json_decode(file_get_contents(__ROOT__ . '/config.json'));

    $dsn = "mysql:host=". $config->dbhost .";port=". $config->dbport .";dbname=". $config->dbname .";charset=utf8";

    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $this->pdo = new PDO($dsn, $config->dbuser, $config->dbpassword, $opt);
  }

  protected function execute($query, $args = []) {
    if(!$this->pdo) {
      $this->connect();
    }

    $query = $this->pdo->prepare($query);
    $query->execute($args);

    if(!$query) {
      throw new \Exception("Query failed");
    }

    return $query;
  }

  protected function executeAndMap($query, $args, $class) {
    return $this->execute($query, $args)->fetchAll(PDO::FETCH_CLASS, $class);
  }

  protected function getDbPrefix() {
    return $this->dbPrefix;
  }
}
