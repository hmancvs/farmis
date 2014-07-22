DROP FUNCTION CAP_FIRST;
CREATE FUNCTION CAP_FIRST (input VARCHAR(255))
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
	DECLARE len INT;
	DECLARE i INT;
	SET len   = CHAR_LENGTH(input);
	SET input = LOWER(input);
	SET i = 0;
	WHILE (i < len) DO
		IF (MID(input,i,1) = ' ' OR i = 0) THEN
			IF (i < len) THEN
				SET input = CONCAT(
					LEFT(input,i),
					UPPER(MID(input,i + 1,1)),
					RIGHT(input,len - i - 1)
				);
			END IF;
		END IF;
		SET i = i + 1;
	END WHILE;
	RETURN input;
END;

UPDATE farmer SET firstname = CAP_FIRST(firstname);
UPDATE farmer SET lastname = CAP_FIRST(lastname);

UPDATE useraccount SET firstname = CAP_FIRST(firstname);
UPDATE useraccount SET lastname = CAP_FIRST(lastname);

UPDATE farmer SET firstname = CONCAT(UCASE(LEFT(firstname, 1)),  LCASE(SUBSTRING(firstname, 2))), lastname = CONCAT(UCASE(LEFT(lastname, 1)),  LCASE(SUBSTRING(lastname, 2)));
UPDATE useraccount SET firstname = CONCAT(UCASE(LEFT(firstname, 1)),  LCASE(SUBSTRING(firstname, 2))), lastname = CONCAT(UCASE(LEFT(lastname, 1)),  LCASE(SUBSTRING(lastname, 2)));
