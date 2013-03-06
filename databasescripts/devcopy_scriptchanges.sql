 -- Reset all email addresses to development addresses and the password to the word password

 -- handle duplicate emails from staging/prod
-- UPDATE useraccount set email = 'csmukasa1@gmail.com' where email = 'csmukasa@gmail.com';
 
UPDATE useraccount set email =  INSERT(email,LOCATE('@', email)+1, 22,'devmail.infomacorp.com'), password = sha1('password');

 -- Overwrite admin email addresses to administrator
UPDATE useraccount set email = 'admin@devmail.infomacorp.com' WHERE id = 1;
UPDATE appconfig set optionvalue = 'admin@devmail.infomacorp.com' WHERE optionname = 'emailmessagesender' OR optionname = 'supportemailaddress';

