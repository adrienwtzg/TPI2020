<?php
//Informations d'authenfication à la base de données
DEFINE('SERVER', '127.0.0.1');
DEFINE('PORT', '');
DEFINE('PSEUDO', 'tpi2020');
DEFINE('PWD', 'Super');
DEFINE('DB_NAME', 'tpi_evaluation');

//Fonction de connexion à la base de données
function connectDB() {
    static $db = null;
    if ($db === null) {
        try {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $db = new PDO("mysql:host=". SERVER .";port=". PORT .";dbname=". DB_NAME, PSEUDO, PWD, $pdo_options);
            $db->exec('SET CHARACTER SET utf8');
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    return $db;
}
