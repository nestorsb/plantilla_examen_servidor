<?php

namespace APP\Core;

use Doctrine\ORM\Tools\Setup;

class EntityManager
{
    private $em;
    private $dbconfig;

    public function __construct()
    {
        $this->dbconfig = json_decode(file_get_contents(__DIR__ . "/../../config/dbConfig.json"), true);

        $paths = array(__DIR__.'/../Entity');
        $isDevMode = true;

        $dbParams = array(
            'host' => $this->dbconfig['server'],
            'driver' => $this->dbconfig['driver'],
            'user' => $this->dbconfig['user'],
            'password' => $this->dbconfig['password'],
            'dbname' => $this->dbconfig['dbname'],
        );
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $this->em = \Doctrine\ORM\EntityManager::create($dbParams, $config);
    }

    

    /**
     * Get the value of em
     */ 
    public function get()
    {
        return $this->em;
    }
}