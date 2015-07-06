# raspi-surveillance

A Raspberry Pi website that can stream video from the attached camera and record surveillance videos when detecting motion.  
This was a school project for module #152 at the [GIB Muttenz](http://www.gibm.ch) (Switzerland).

*Attention: This is a practice project and is in no way intended or suitable to be used for serious surveillance use cases.
Among other serious security issues, there is no user authentication and unencrypted connections are used.*

## Features
- Videostreaming: Starts a live HTTP videostream into the network (only local camera)
- Motion Detection: Automatically records and saves videos when motion is detected (only local camera)
- Network Cameras: Manage any additional network cameras and view their livestreams
- In-Browser Video Player: View livestreams and recorded videos directly in the browser
- Video Archive: View and manage the automatically recorded surveillance videos
- Modern, easy to use and responsive user interface

## Screenshots
### Camera Control & Network Camera Management
![Camera Control & Network Camera Management](/doc/screenshots/camera-control-and-network-camera-management.jpg "Camera Control & Network Camera Management")

### Video Archive
![Video Archive](/doc/screenshots/video-archive.jpg "[Video Archive")

## Installation
Detailed installation instructions are available in the [user manual](doc/User Manual.pdf), sections "Installation" and "Konfiguration" (written in German).  

Requirements:  
- Raspberry Pi running raspbian
- Raspberry Pi Camera Module (no USB cameras)
- Webserver (running on Pi, tested on Apache 2.4)
- PHP 5.4 or better (running on Pi)
- MySQL Server 5.6 or better
- VLC media player with browser plugin on clients (optional, for in-browser video player). Currently only supports Mozilla Firefox.

The script [setup/setup-pi (experimental).sh](setup/setup-pi (experimental).sh) can **partially** take over installing the required software.

1. Download the latest [release](https://github.com/drasive/raspi-surveillance/releases/) to your Raspberry Pi
2. Extract the folder /Website to the webserver folder (e.g. /var/www/htdocs/raspi-surveillance)
3. Extract the file /Setup/motion to /usr/bin/motion
4. Extract the file /Setup/motion.conf to /env/motion.conf
5. Make sure the user "www-data" has sufficient access rights to the website (read for all, write and execute for some folders)
6. Make sure the user "www-data" has execution rights to /usr/bin/motion
7. Make sure the user "motion" has write access to the target directory (default /var/www/htdocs/raspi-surveillance/public/videos) and log file (default /var/www/motion.log)
8. Run /Setup/create_database.sql or manually create a new MySQL database
9. Configure the DB_* properties in the website configuration file (.env) according to your environment
10. Run ```php artisan migrate``` in the website folder to create the database tables
11. Run ```php artisan key:generate``` to generate a secure, personal application key

You can access the website from any webbrowser that can reach your Raspberry Pi (http://[Raspberry-IP]/[Website-Folder], e.g. http://192.168.0.8/htdocs/raspi-surveillance/public)

## Documentation
The documentation is available in the folder [/doc](doc).  
The [user manual](doc/User Manual.pdf) contains detailed instructions on how to install, configure and use the application (written in German).

## Development
Requirements:
- [Composer](https://getcomposer.org/)
- [Bower](http://bower.io/)

1. Get source code: ```git clone https://github.com/drasive/raspi-surveillance.git```
2. Get PHP dependencies: ```composer install``` in /src
3. Get frontend dependencies: ```bower install``` in /src
4. Create database: Run [setup/create_database.sql](setup/create_database.sql) or manually create a new database
5. Configure application: Copy src/.env.example to src/.env and change APP_ENV and the DB_* properties according to your environment
6. Create database tables: Run ```php artisan migrate``` in /src
7. Fill database with test data (optional): Run ```php artisan db:seed``` in /src
8. Run application: Run ```php artisan serve``` in /src or put the content of /src on a webserver

All source code can be found in the folder [/src](src). The PHP framework Laravel 5.0 is used and all files are structured accordingly.
The folder [/src/resource/scripts](src/resources/scripts) contains the bash scripts used to interact with the Raspberry Pi.  
The project is developed using Visual Studio 2013, but you can use any IDE or text editor you want.  

## License
This project is licensed under the GPLv3 License.  
See the [license file](LICENSE) for detailed information.
