CREATE DATABASE IF NOT EXISTS giphydb;
CREATE DATABASE IF NOT EXISTS giphydb_test;

CREATE USER IF NOT EXISTS 'giphyuser'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON giphydb.* TO 'giphyuser'@'%';
GRANT ALL PRIVILEGES ON giphydb_test.* TO 'giphyuser'@'%';
FLUSH PRIVILEGES;

