2011-08-22
PirateGaspard Presents:
PointClickPress Beta release
www.pointclickpress.org

PointClickPress is an open source web app game engine for the creation of point and click style games built using Kohana, JQuery, PHP, and good ol' HTML. 
It allows you to create Interactive Stories that you can play in any browser and share with your friends!

PointClickPress has been tested with:
Apache 2.2
PHP 5.3
MySQL 5
FireFox & Chrome 
Teh interwebz

If you have any problems installing or would like to report a bug:
www.pointclickpress.org/forums/

To Install:
1) Mod_rewrite must be enabled in Apache
2) Create an empty MySQL database
3) Edit \config\database.php and enter your database information.
4) Edit .htaccess to make sure RewriteBase is pointing to the correct folder
5) Navigate to WEBROOT/install 
6) Enter a Admin username and password then click install
7) Remove install directory WEBROOT/views/admin/install when finished.

Notes:
If "index.php" is showing in the URL: 
- Check to ensure that mod_rewrite is turned on 
- Check that the REWRITEBASE is set to your PCP webroot in the .htaccess file. 

As always if you have any problems installing or would like to report a bug:
www.pointclickpress.org/forums/
