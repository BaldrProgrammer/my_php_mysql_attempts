-- 1
create user 'sklep_user'@'localhost'
identified by 'bezpieczne123';

-- 2
grant all privileges on customers
to 'sklep_user'@'localhost';

-- 3
drop user 'sklep_user'@'localhost';
