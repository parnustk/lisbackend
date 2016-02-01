# Learning Information System 

## Developers

    Eleri Apsolon - developer, eleri.apsolon@gmail.com
    Marten Kähr - developer
    Juhan Kõks - developer, juhankoks@gmail.com
    Kristen Sepp - developer, seppkristen@gmail.com
    Arnold Tserepov - developer, tserepov@gmail.com
    Alar Aasa - developer, alar@alaraasa.ee
    Sander Mets - developer, software architect, team lead sandermets0@gmail.com

## What

Purpose of the current project is to provide web based e-diary for http://www.saksatk.ee/en/. Deadline is 1st June of 2016. 
Project will be taken into account as internship and final practical work to graduate school for all developers involved with the project.  

## Starting point

Team has been provided with documentation by 2015 gradutates. Docs can be found here:

https://drive.google.com/file/d/0B9YsOhSay3OcdGRmN0lGOXBtcXc/view relevant pages are 12-18.

## Technologies used

List of used technologies:

    Zend2, 
    Doctrine2, 
    PHPUnit, 
    AngularJS, 
    RequireJS, 
    NodeJS, 
    Gulp, 
    Foundation6 sites
    Karma or Casper

## Technical requirements

Server side logic(back end) has to be covered by automated acceptance and functional tests.  
Client side has to be covered at least with E2E tests for models.  

## Material

    "PHP Data Persistence with Doctrine 2 ORM Concepts, Techniques and Practical Solutions" by Michael Romer
    http://framework.zend.com/manual/current/en/index.html  
    
## Demo link
TODO

## Installation

    Instructions can be found - https://github.com/parnustk/lisbackend/wiki/Install  

## Quick helper

### Linux:

    php vendor/bin/doctrine-module orm:validate-schema
    php vendor/bin/doctrine-module orm:schema-tool:create
   
### Windows:

    vendor\bin\doctrine-module.bat orm:validate-schema
    vendor\bin\doctrine-module.bat orm:schema-tool:create

### API Documentation

#### Install apigen;

    See http://www.apigen.org/

### Generate api docs:

    apigen generate -s "module/Administrator/src/Administrator/Controller/","module/Teacher/src/Teacher/Controller/","module/Student/src/Student/Controller/" -d public/apidocs --template-theme "bootstrap" --title "LIS eDiary API documentation" --no-source-code

### Doctrine 2 Custom types:

    https://github.com/doctrine/DoctrineORMModule/blob/master/docs/EXTRAS_ORM.md
    http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/cookbook/custom-mapping-types.html
    http://stackoverflow.com/questions/8374908/where-to-encrypt-decrypt-my-data
    https://github.com/doctrine/DoctrineORMModule/blob/master/docs/configuration.md

### Doctrine2 Native SQL

    http://www.wjgilmore.com/blog/2011/04/09/the-power-of-doctrine-2-s-custom-repositories-and-native-queries/

### Github token

https://github.com/composer/composer/issues/3542

## Random
	
In production you should not update your dependencies, you should run  
  
>$ composer install   
  
which will read from the lock file and not change anything. From StackOverlfow
