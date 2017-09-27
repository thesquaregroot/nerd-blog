--
-- WARNING: The accounts this file creates are intended to be used only for
--          testing purposes.  DO NOT use them in a production environment.
--

CREATE USER `test`@'localhost' IDENTIFIED BY 'test';
GRANT SELECT ON `nerdblog`.* TO `test`@'localhost';
GRANT INSERT ON `nerdblog`.`post_comments` TO `test`@'localhost';

CREATE USER `admin`@'localhost' IDENTIFIED BY 'admin';
GRANT SELECT, INSERT, UPDATE, DELETE ON `nerdblog`.* TO `admin`@'localhost';

