# Admin Panel using laravel 6 for WORX Football booking


## Features

- __Adminpanel__ with administrator user managing users and matches
- __Adminpanel__ provide API for ios app

- - - - -

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer update or composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed or php artisan migrate:fresh --seed__ (it has some seeded data for your testing)
- Run __php artisan passport:install__ (optional)
- In your __.env__ file add your Google Maps API key: `GOOGLE_MAPS_API_KEY=AIzaSyBi2dVBkdQSUcV8_xxxxxxxxxxxx`
- That's it: launch the main URL. 
- You can login to adminpanel by going go `/login` URL and login with credentials __admin@admin.com__ - __password__


- - - - -


## License

BSD


