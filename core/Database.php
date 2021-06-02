<?php
namespace app\core;


/**
 * Class Database
 * @package app\core
*/
class Database
{

    /**
     * @var \PDO
    */
    public \PDO $pdo;


    /**
     * Database constructor.
     * @param array $config
    */
    public function __construct(array $config)
    {
        $dsn  = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Apply migrations
    */
    public function applyMigrations()
    {
         $this->createMigrationsTable();
         $appliedMigrations = $this->getAppliedMigrations();

         $files = scandir(Application::$ROOT_DIR.'/migrations');
         $toApplyMigrations = array_diff($files, $appliedMigrations);

         $newMigrations = [];

         foreach ($toApplyMigrations as $migration) {
             if ($migration === '.' || $migration == '..') {
                 continue;
             }

             require_once Application::$ROOT_DIR.'/migrations/'. $migration;

             $className = pathinfo($migration, PATHINFO_FILENAME);
             $instance = new $className();

             $this->log("Applying migration $migration");
             $instance->up();
             $this->log("Applied migration $migration");
             $newMigrations[] = $migration;
         }


         if (! empty($newMigrations)) {
             $this->saveMigrations($newMigrations);
         }else{
             $this->log("All migrations are applied");
         }
    }


    /**
     *
     */
    public function createMigrationsTable()
    {
        $this->pdo->exec("
          CREATE TABLE IF NOT EXISTS migrations (
              id int AUTO_INCREMENT PRIMARY KEY,
              migration VARCHAR(255),
              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
          ) ENGINE=INNODB;");
    }


    /**
     * get applied migrations
    */
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }


    /**
     * @param array $migrations
    */
    public function saveMigrations(array $migrations)
    {
        /* dump($migrations);
        $migrations = array_map(fn($m) => "('$m')", $migrations);
        dump($migrations);
        */

        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }


    /**
     * @param $sql
     * @return false|\PDOStatement
    */
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }



    /**
     * @param $message
    */
    protected function log($message)
    {
        echo '['. date('Y-m-d H:i:s') .'] - '. $message .PHP_EOL;
    }
}