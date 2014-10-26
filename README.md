COMMENTINGSYSTEM
================

A sort of blog where anybody can post and anybody can comment posts.



INSTALL:
 1) Extract source code to a folder in your web server  (e.g bloggingsystem)
 2) Modify db connection in config/application.config.php
 3) Point your browser to http://myWebServerHost/MyBlogSystemFolder/install.php
    If everything went right, you should be redirected to index.php
     - Remove or rename install.php so as to avoid dropping your blog's tables.
    
    SECOND OPTION:
       1) LOG ONTO mysql
       2) create a database with the same name as the one set in application.config.php
       3) launch execute| import | mysqldump  data/bloggingsystem.sql
       
