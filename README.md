# LearningInformationSystem

## LIS Restful + ORM  Backend prerequisites
PHP >= 5.4  
Mysql >= 5.4  

## If You want to set up Your own new Zend2 + ORM project 
follow: 

    http://framework.zend.com/manual/current/en/user-guide/skeleton-application.html  
    https://getcomposer.org/doc/00-intro.md  
    http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/  

### Instructions

Following instructions are written for Ubuntu and Lamp. All can be accomplished 
using Mac or Windows or other Linux distro.  
Install Main project - open up terminal

    mkdir ~/web # Your own path
    cd ~/web # Your own pat
    mkdir lis # Your own pat
    cd lis # Inside project root
    git clone https://github.com/parnustk/lisbackend.git .
    curl -sS https://getcomposer.org/installer | php
    php composer.phar update  

You should have now folder vendor in Your project's root folder.  
Composer update follows composer.json

### Create virtual host  

Add following line to /etc/hosts :

    127.0.0.1       lis.local

Add file /etc/apache2/sites-available/lis.local.conf:

    <VirtualHost lis.local:80>

        ServerName lis.local
	    ServerAlias lis.local
        ServerAdmin webmaster@local
        DocumentRoot /home/sander/web/lis/public 

        <Directory /home/sander/web/lis/public>
                Options FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
		Require all granted
        </Directory>

        ErrorLog /var/www/html/log/lis_error.log 
        CustomLog /var/www/html/log/lis_access.log combined 

    </VirtualHost>

Add file /etc/apache2/sites-available/lis.local-ssl.conf:

    <IfModule mod_ssl.c>
	<VirtualHost lis.local:443>
		ServerAdmin webmaster@local
		ServerName lis.local
		ServerAlias lis.local
        	DocumentRoot /home/sander/web/lis/public
		
		SetEnv APPLICATION_ENV "development"
		<Directory /home/sander/web/lis/public>
		        Options FollowSymLinks MultiViews
		        AllowOverride All
		        Order allow,deny
		        allow from all
			Require all granted
		</Directory>

		ErrorLog /var/www/html/log/lis_ssl_error.log 
	        CustomLog /var/www/html/log/lis_ssl_access.log combined

		SSLEngine on
		SSLCertificateFile	/etc/ssl/certs/ssl-cert-snakeoil.pem 
		SSLCertificateKeyFile /etc/ssl/private/ssl-cert-snakeoil.key 
		
		<FilesMatch "\.(cgi|shtml|phtml|php)$">
			SSLOptions +StdEnvVars
		</FilesMatch>

		<Directory /usr/lib/cgi-bin>
				SSLOptions +StdEnvVars
		</Directory>

		BrowserMatch "MSIE [2-6]" \
				nokeepalive ssl-unclean-shutdown \
				downgrade-1.0 force-response-1.0
		# MSIE 7 and newer should be able to use keepalive
		BrowserMatch "MSIE [17-9]" ssl-unclean-shutdown
	</VirtualHost>
    </IfModule>


Enable virtualhost and restart apache2:

    sudo a2ensite lis.local.conf
    sudo a2ensite lis.local-ssl.conf
    sudo a2enmod ssl  
    sudo service apache2 restart

Or oneliner:

    sudo a2ensite lis.local.conf && sudo a2ensite lis.local-ssl.conf && 
        sudo a2enmod ssl && sudo service apache2 restart

More apache modules:

    sudo a2enmod headers
    sudo a2enmod rewrite

### Set up ORM DB connection

Add database in your local MySQL(or other) server. MySQL possible collation for database is utf8 bin - enables UTF8 safe case-sensitivity.
Add file config/autoload/doctrineorm.local.php:

    <?php
    return [
        'doctrine' => [
            'connection' => [
                // default connection name
                'orm_default' => [
                    'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                    'params' => [
                        'host'     => 'localhost',
                        'port'     => '3306',
                        'user'     => 'root', //Your DB user
                        'password' => '123456', //Your DB password
                        'dbname'   => 'lis', //Your DB name
                        'charset' => 'utf8',
                        'driverOptions' => [
                            1002 => 'SET NAMES utf8'
                        ]
                    ]
                ]
            ],
            'configuration' => [
                'orm_default' => [
                    'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                    'proxy_namespace' => 'DoctrineORMModule\Proxy',
                ]    
            ]
        ],
    ];

All done! Open https://lis.local/ and http://lis.local/ to test.

## Install database from Entities

### Use Doctrine CLI

Create Entities against database(in current projects root directory):
    
    php vendor/bin/doctrine-module orm:schema-tool:create

Now installation is complete time for sunning tests:

    TODO

#### More helpers

Validate tables:

    php vendor/bin/doctrine-module orm:validate-schema

Delete DATABASE - NB! AKA DROP:

    php vendor/bin/doctrine-module orm:schema-tool:drop --force

Check changes/difference SQL:

    php vendor/bin/doctrine-module orm:schema-tool:update --dump-sql

Make update sql::

    php vendor/bin/doctrine-module orm:schema-tool:update --force

Generate repositories:
    
    php vendor/bin/doctrine-module orm:generate-repositories module/Datac/src/

Generate proxies:

    vendor/bin/doctrine-module orm:generate-proxies


### Optional Helper ZF-tool

http://framework.zend.com/manual/current/en/modules/zendtool.introduction.html

Install in project root:

  php composer.phar require zendframework/zftool:dev-master
  

Usage vendor/bin/zf.php:
  
  vendor/bin/zf.php

Create module:

    vendor/bin/zf.php create module Core

Create controller

    vendor/bin/zf.php create   Sample Core

## Testing

We will use FUNCTIONAL testing. Testing will be against REAL DATABASE in LOCAL ENVIRONMENT.  
In other words we are testing Controllers only if no volunteers found.
We probably have no time for UNIT tests.  
Test stories will be generated using TSLgenerator.  

### PHPUnit

https://phpunit.de/getting-started.html  
Install php unit(Latest phpunit reqs php >= 5.6 so we use older version):
    
    wget https://phar.phpunit.de/phpunit-old.phar
    mv phpunit-old.phar phpunit.phar
    chmod +x phpunit.phar
    sudo mv phpunit.phar /usr/local/bin/phpunit
    phpunit --version

### Testing module

In projects root:

    cd module/Core/src/test
    phpunit
    
## Future auth research
https://zfmodules.com/:

    ZfcUserDoctrineORM
    LdcZfcUserOAuth2

TODO first make it work with ZfcUserDoctrineORM
after succeed move to OAUTH2 if theres time. 

## Validation of entities
https://github.com/coolcsn/CsnAuthorization/blob/master/src/CsnAuthorization/Entity/Resource.php
http://luci.criosweb.ro/simplify-handling-of-tables-entities-forms-and-validations-in-zf2-by-using-annotations/

## Doctrine hydrator
See:

    https://github.com/doctrine/DoctrineModule/blob/master/docs/hydrator.md

## Front End research

Reqs:

    MV(C)
    Model validation
    Models for REST important
    Templates or similar
    Routing with or without Window history
    SAP
    Easy for beginners
    Good documentation or examples
    Deferred
    RequireJS ready
    
Thoughts:

    CanJS
    AngularJS

http://canjs.com/guides/Why.html  
http://www.sitepoint.com/using-requirejs-angularjs-applications/  
http://blog.falafel.com/building-single-page-applications-with-canjs-and-requirejs/  
winner at the moment CanJs

## Auth 
think of http://framework.zend.com/manual/current/en/modules/zend.authentication.adapter.http.html

## CanJS AMD

Helps:

    https://github.com/kloy/diving-into-canjs-amd  
    http://canjs.com/guides/using-production.html  
    https://github.com/canjs/can-compile/tree/master/example  
    google CanJs in production  
    https://github.com/bitovi/canjs/issues/111 (set headers)

http://stackoverflow.com/questions/26290976/canjs-extending-can-model-with-additional-methods

## Final winner AngularJS
After some extra research - final winner is AngularJS.

### Set up
Gulp:

    https://github.com/paislee/healthy-gulp-angular  
    https://github.com/Hyra/Frickle/  

Examples:
    
    http://www.w3schools.com/angular/
    http://jasonwatmore.com/post/2015/03/10/AngularJS-User-Registration-and-Login-Example.aspx  
    http://www.codeproject.com/Articles/637430/Angular-js-example-application  
    http://www.codeproject.com/Articles/607873/Extending-HTML-with-AngularJS-Directives  

Rest($resource):

    http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/

