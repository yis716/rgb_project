CREATE TABLE news (
   num INT NOT NULL AUTO_INCREMENT,
   id CHAR(15) NOT NULL,
   name CHAR(10) NOT NULL,
   nick CHAR(10) NOT NULL,
   category VARCHAR(20) NOT NULL,
   subject VARCHAR(255) NOT NULL,
   content TEXT NOT NULL,
   regist_day CHAR(20),
   hit INT DEFAULT 0,
   is_html CHAR(1),

   file_name_0 VARCHAR(100),
   file_copied_0 VARCHAR(100),
   
   PRIMARY KEY(num)
);