# Radosław Niestrój sample-magento2 project
Opensource project intended for commercial and private use, the code included in the project can be used completely free of charge in commercial and dedicated projects.

## Project launch on local env
###### **Work only for Linux!**
1. copy _docker-compose.yml.sample_ to _docker-compose.yml_
2. copy _app/etc/env.php.sample_ to _app/etc/env.php_
3. unpack catalog _docker.tar.gz_ and _db.tar.gz_
4. run command _docker-compose up -d_
5. import database file from db folder (_mysql -uroot -proot database -h127.0.0.1< [path]/dump.sql_)
6. run commands inside php container (_docker-compose exec php bash_): 
   1. _bin/magento module:enable --all_
   2. _bin/magento setup:upgrade_
   3. _bin/magento setup:di:compile_
   4. _bin/magento indexer:reindex_
7. urls:
   1. front: [https://samplemagento2.loc/](https://samplemagento2.loc/admin), all customers account password is _Password123_
   2. admin: [https://samplemagento2.loc/admin](https://samplemagento2.loc/admin), admin login: _admin_, password: _Password123_

##### TO DO: improve and test instruction (requires technologies)
