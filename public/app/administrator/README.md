# Admin front-end app

## Development prerequisites

You should have following software installed in your computer:  

    git
    nodejs
    npm
    bower
    gulp  

## Install

> npm install  
> bower install  

## Add js config
 
Create lis/dist/globals.config.local.js with content:

    (function (window) {
        window.LisGlobals = {
            RestUrl: 'http://lis.local/admin/',
            RegisterUrl: 'http://lis.local/lisauth/'
        };
    }(window));
 
## Run development environment

Be sure that BE is working locally or set remote BE

> gulp  