
ALTER TABLE `useraccount` DROP FOREIGN KEY fk_useraccount_createdby, DROP FOREIGN KEY fk_useraccount_lastupdatedby;
ALTER TABLE `farmgroup` DROP FOREIGN KEY fk_farmgroup_createdby, DROP FOREIGN KEY fk_farmgroup_lastupdatedby;
ALTER TABLE `farmgroup` DROP FOREIGN KEY fk_farmgroup_addressidx;
ALTER TABLE `farmgroup` DROP FOREIGN KEY fk_farmgroup_manageridx;
ALTER TABLE `farmgroup` DROP KEY fk_farmgroup_createdby, DROP KEY fk_farmgroup_lastupdatedby, DROP KEY fk_farmgroup_addressidx, DROP KEY fk_farmgroup_manageridx;