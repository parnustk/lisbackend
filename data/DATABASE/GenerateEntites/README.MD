# Generate Entities with Doctrine2 CLI 

## Install
Here in data/GenerateEntities first run:
    
    curl -sS https://getcomposer.org/installer | php
    php composer.phar self-update
    php composer.phar update

Add data/GenerateEntities/bootstrap.php with your database params:

    <?php

    require_once "vendor/autoload.php";

    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;

    $paths = array("src/Datac/Entity");
    $isDevMode = true;

    // the connection configuration
    $dbParams = [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '123456',
        'dbname' => 'lis',
    ];

    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
    $entityManager = EntityManager::create($dbParams, $config);

## Create Entities
You have to of course have some tables in Your database.  
Run:

    php vendor/bin/doctrine orm:convert-mapping --namespace="Core\\Entity\\" --force  --from-database annotation ./src

Now if all went good check src folder. It will override existing entities, but no worries, these here are only drafts.  
Entities for using reside in Core module.  

## Really goood Doctrine helper

http://ormcheatsheet.com/

## Conclusion
We need to use Skipper trial as generating entities with cli will require a lot of extra work on Entities to get them represent full schema rewuired.

Flaws with first look:

    missing cascade
    onetoone only
    missing bidirectional refs