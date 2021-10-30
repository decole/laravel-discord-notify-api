-- create test db
CREATE DATABASE discord_bot_test CHARACTER SET utf8 COLLATE utf8_general_ci;

-- add to test db laravel user privileges
GRANT ALL PRIVILEGES ON `discord_bot_test`.* TO 'laravel'@'%' WITH GRANT OPTION;
