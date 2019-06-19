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

Start game
        
    docker run --rm -ti -v $PWD:/opt/project -w /opt/project  devilbox/php-fpm-7.4 php bin/start_game.php <first_user_id> <second_user_id>

User movement 

- Any string as a movement is valid
- User can win the game randomly after a movement

```
docker run --rm -ti -v $PWD:/opt/project -w /opt/project  devilbox/php-fpm-7.4 php bin/user_movement.php <user_id > <game_id> <movement>
```

Game Status
        
    docker run --rm -ti -v $PWD:/opt/project -w /opt/project  devilbox/php-fpm-7.4 php bin/game_status.php <game_id>


### Maintenance

Delete storage files
        
    sudo rm -rf $PWD/var/file_repositories/*.file_db