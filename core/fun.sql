DELIMITER //
CREATE FUNCTION ifone(a int(1)) RETURNS int(1)
BEGIN
IF a = 1 THEN
RETURN 1;
ELSE RETURN 0;
END IF;
END;//
DELIMITER ;

DELIMITER //
create function ifzero(x int(1)) returns int(2) begin if x = 0 then return 1; else return 0; end if; end;//
DELIMITER ;

create function iftwo(x int(1)) returns int(2) begin if x = 2 then return 1; else return 0; end if; end;//

DELIMITER //
CREATE FUNCTION paycheck(a int(1), b decimal(10,2)) RETURNS decimal(10,2)
BEGIN
IF a = 1 THEN
RETURN b;
ELSEIF a = 0 THEN
RETURN -b;
ELSE RETURN 0;
END IF;
END;//
DELIMITER ;

DELIMITER //
CREATE FUNCTION formatEsp(n decimal(10,2)) RETURNS varchar(20)
BEGIN
RETURN CONCAT(REPLACE(FORMAT(FLOOR(n),0),',','.'),',',SUBSTRING_INDEX(FORMAT(n,2),'.',-1));
END;//
DELIMITER ;
