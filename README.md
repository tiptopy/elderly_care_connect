Installation Guide:

Confirm the version of php you have by running php --version from your terminal, if it is not V8.1 Unistall and 
1. reinstall Version 8.1 from the links provided above. (Only 8.1 is compatible with PECL for mongodb intergration)

Once you have php V8.1 installed, 
2. install PECL from the link below, extract the zip and copy and paste the php_mongodb.dll to the php extensions directory, always located within C:\xampp\php\ext

Once done, 
3. open the php.ini configuration file and search and find the line with the text extension=mysqli (Hold Ctr+f then paste the text to find its occurence) and add a new line just above that and paste the text, extension=php_mongodb.dll. It should now look like;

extension=php_mongodb.dll
extension=mysqli

From the same file, php.ini, 
4. find the line(Ctr+f) with the text extension=gd and remove the first semicolon character in that line.(For image compression functionality)

5. Now save the file and close it.

6. Install the remaining requirements, composer and mongodb, and ensure you add their installation bin path them to your system environment variables.(google how to add the bin path to system variables incase you don't know.

Now open vs code and 
7. install PHP Server by brapifra (We will be using this to serve project via localhost port 3000 by just right clicking from your open php file within vs code)

Once done, just pull the github repository https://github.com/tiptopy/elderly_care_connect and decide where to store it locally(Or extract the contents within the Elderly_Care_Connect zip file).

NB: Ensure you have internet connectivity since the Database in on an online server.

Everything should work except for payment intergration, Sending SMS and whatsapp message, for that to work, just add a .env file within the root of the project directory, then contact admin(0741816281) for the api keys to paste within that file. To avoid misuse and Impersonations, API keys used for transactions and sending messages cannot be made publicly available, hence you will need to contact admin for them.

Download Links:
Pecl:
https://downloads.php.net/~windows/pecl/releases/mongodb/1.13.0/php_mongodb-1.13.0-8.1-nts-vs16-x64.zip
Composer:
https://getcomposer.org/Composer-Setup.exe
Php V8.1:
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.1.25/xampp-windows-x64-8.1.25-0-VS16-installer.exe/download
MongoDB Compass:
https://downloads.mongodb.com/compass/mongodb-compass-1.42.2-win32-x64.exe
