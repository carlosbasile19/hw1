CREATE DATABASE diario;
USE diario;

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  email varchar(255) UNIQUE NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE diaries (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE entries (
  id int(11) NOT NULL AUTO_INCREMENT,
  diary_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (diary_id) REFERENCES diaries(id)
);

CREATE TABLE favorites (
  id int(11) NOT NULL AUTO_INCREMENT,
  entry_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (entry_id) REFERENCES entries(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

DELIMITER //

CREATE TRIGGER delete_favorite
BEFORE DELETE ON entries
FOR EACH ROW
BEGIN
  DELETE FROM favorites WHERE entry_id = OLD.id;
END//

DELIMITER ;
