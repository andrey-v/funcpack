# Таблица склонений
CREATE TABLE IF NOT EXISTS `prefix_funcpack_sclonenie` (
  `sclonenie_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sclonenie_P1` VARCHAR(200)     NOT NULL,
  `sclonenie_P2` VARCHAR(200)     NOT NULL,
  `sclonenie_P3` VARCHAR(200)     NOT NULL,
  `sclonenie_P4` VARCHAR(200)     NOT NULL,
  `sclonenie_P5` VARCHAR(200)     NOT NULL,
  `sclonenie_P6` VARCHAR(200)     NOT NULL,

  PRIMARY KEY (`sclonenie_id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;