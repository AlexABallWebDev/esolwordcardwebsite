CREATE TABLE users (
	user_id      INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(30) NOT NULL,
	last_name VARCHAR(30) NOT NULL,
	email         VARCHAR(40) NOT NULL UNIQUE,
	password  CHAR(40) NOT NULL
);
CREATE TABLE cards (
	card_id     			 INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	user_id     		 	 INT UNSIGNED NOT NULL,
	chapter      		 	 INT NOT NULL,
	word          		 	 VARCHAR(30) NOT NULL,
	part_of_speech       	 VARCHAR(30) NOT NULL,
	word_in_use  		 	 VARCHAR(350) NOT NULL,
	page_number 		 	 INT NOT NULL,
	definition           	 VARCHAR(350) NOT NULL,
	example_sentence	 	 VARCHAR(350) NOT NULL,
	grade 				 	 INT NOT NULL,
	comment						TEXT,
	timestamp 			 	 DATETIME NOT NULL,
	is_visible						BOOLEAN NOT NULL DEFAULT TRUE,
	FOREIGN KEY (user_id) 	 REFERENCES users(user_id)
);