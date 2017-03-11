CREATE TABLE `ts`.`jurtruzp` (
`Id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`FIO` varchar( 50 ) NOT NULL ,
`NamePFR` varchar( 15 ) NOT NULL ,
`NomerKS` varchar( 14 ) NOT NULL ,
`DateKS` date NOT NULL ,
`NomerISXD` varchar( 14 ) NOT NULL ,
`DateISXD` date NOT NULL ,
`Deistvie` int( 11 ) NOT NULL ,
`IdUserCreate` int( 11 ) NOT NULL ,
`DateOtv` date NOT NULL ,
`NomerOtv` varchar( 10 ) NOT NULL ,
`Rezult` varchar( 100 ) NOT NULL ,
`status` int( 11 ) NOT NULL DEFAULT '0',
PRIMARY KEY ( `Id` ) ,
KEY `Id` ( `Id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT =0;

ALTER TABLE `jurtruzp` ADD `NamePFR_RO` VARCHAR( 15 ) NOT NULL DEFAULT '”œ‘– ‚ „. ¿ÁÓ‚Â' AFTER `FIO` 