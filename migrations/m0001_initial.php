<?php


class m0001_initial {

      public function up()
      {
          $db = \app\core\Application::$app->db;

          $SQl = "CREATE TABLE IF NOT EXISTS users (
                     id int AUTO_INCREMENT PRIMARY KEY,
                     email VARCHAR(255) NOT NULL,
                     firstname VARCHAR(255) NOT NULL,
                     lastname VARCHAR(255) NOT NULL,
                     status TINYINT DEFAULT 0 NOT NULL,
                     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                  ) ENGINE=INNODB;";

          $db->pdo->exec($SQl);
      }


      public function down()
      {
          $db = \app\core\Application::$app->db;
          $SQl = "DROP TABLE users;";
          $db->pdo->exec($SQl);
      }
}