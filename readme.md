# Good Gateway Football

[![Build Status](https://travis-ci.org/sergeyvolkov/ggf.svg)](https://travis-ci.org/sergeyvolkov/ggf)
[![Dependency Status](https://gemnasium.com/sergeyvolkov/ggf.svg)](https://gemnasium.com/sergeyvolkov/ggf)

[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/sergeyvolkov/ggf?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

<a href="https://good-gateway-football.herokuapp.com" target="_blank">Demo</a>

## Setup development environment with Homestead (per-project installation)

1. Clone project

2. Run the following command to prepare project and install vendors:
	
    ```
    EMBER_ENV=development composer setup
	```
	
3. Setup homestead/vagrant environment:
	
    ```
    ./vendor/bin/homestead make
	```

	> Remove the following lines from Homestead.yaml if you don't have this SSH keys on your machine (http://laravel.com/docs/5.0/homestead#installation-and-setup):
	> 
        authorize: ~/.ssh/id_rsa.pub
        keys:
            - ~/.ssh/id_rsa
	    

4. Run vagrant
	
    ```
    vagrant up
    ```

5. Next, you should login to your virtual box through `vagrant ssh` and run the following command in the root folder of application:
	
    ```
    php artisan migrate
    ```

6. Add facebook settings to .env:
	

        FACEBOOK_APP_ID=1
        FACEBOOK_APP_SECRET=1
        FACEBOOK_REDIRECT_URI=http://192.168.10.10/


7. Finally, browse [http://192.168.10.10](http://192.168.10.10), you should see the main page of application.


## Testing

Add new database to the particular list in Homestead.yaml:
```
databases:
    - homestead
    - homestead_test
```
Reload vagrant and run `phpunit`:
```
vendor/bin/phpunit
```
