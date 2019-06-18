Requires docker

Requires PHP 7.4: available here

        docker pull devilbox/php-fpm-7.4:latest
 
Instructions
    
        composer install --ignore-platform-reqs

Run tests
        
        docker run --rm -ti -v $PWD:/opt/project -w /opt/project devilbox/php-fpm-7.4 php vendor/bin/phpunit -c phpunit.xml