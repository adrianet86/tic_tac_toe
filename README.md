### Requirements

   * Docker
   * PHP 7.4

 
### Setup
        # From root path of project
        
        docker pull devilbox/php-fpm-7.4:latest
        
        docker pull composer
        
        docker run --rm -ti -v $PWD:/opt/project -w /opt/project composer install --ignore-platform-reqs
        

### Tests
        
        docker run --rm -ti -v $PWD:/opt/project -w /opt/project devilbox/php-fpm-7.4 php vendor/bin/phpunit -c phpunit.xml

### Application commands

Create user
 
        docker run --rm -ti -v $PWD:/opt/project -w /opt/project  devilbox/php-fpm-7.4 php bin/create_user.php <username>
        
Delete user 
        
        docker run --rm -ti -v $PWD:/opt/project -w /opt/project  devilbox/php-fpm-7.4 php bin/delete_user.php <user_id>


### Maintenance

Delete storage files
        
        sudo rm -rf $PWD/var/file_repositories/*.file_db