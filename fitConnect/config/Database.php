<?php

/**
 * Connexion PDO centralisée à la base FitConnect.
 * Implémentation en Singleton : une seule instance de connexion
 * est réutilisée dans toute l'application (Repositories).
 */
class Database
{
    private static ?PDO $instance = null;

    // ---- Paramètres de connexion ----
    private static string $host    = '127.0.0.1';
    private static string $port    = '3306';
    private static string $dbname  = 'fitconnect';
    private static string $charset = 'utf8mb4';
    private static string $user    = 'root';
    private static string $pass    = '';

    private function __construct()
    {
        // Constructeur privé : empêche l'instanciation directe (pattern Singleton)
    }

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                self::$host,
                self::$port,
                self::$dbname,
                self::$charset
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false, // vraies requêtes préparées côté serveur
            ];

            try {
                self::$instance = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                // On ne divulgue jamais les identifiants dans le message d'erreur
                throw new PDOException('Connexion à la base de données impossible : ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    // Empêche le clonage et la désérialisation de l'instance (respect du Singleton)
    private function __clone() {}
    public function __wakeup()
    {
        throw new \Exception('Impossible de désérialiser un Singleton.');
    }
}
