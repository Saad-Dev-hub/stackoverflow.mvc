# Stackoverflow Project
## Description
This project is based on the Stackoverflow website.
Using MVC Design Pattern 
## Installation
### Go to config directory:
[C:\xampp\apache\conf\extra\httpd-vhosts.conf](httpd-vhosts.conf)
### Add the following line:
### To customize Virtual Host
```
<VirtualHost *>
 DocumentRoot "C:\XAMPP\htdocs\MVC\public"
 ServerName  stackoverflow.mvc
 <Directory "C:\XAMPP\htdocs\MVC\public">
Options Indexes FollowSymLinks Includes ExecCGI
Order allow,deny
 Allow from all
</Directory>
</VirtualHost>
```
#### Then go to Hosts file and add the following line:
```
127.0.0.1   stackoverflow.mvc
```
#### Require MySQL Database Import stackoverflow.sql to your  database
### Then restart Apache
### Then go to http://stackoverflow.mvc/

