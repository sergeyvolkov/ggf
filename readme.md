# Good Gateway Football

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