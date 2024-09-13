CREATE TABLE `scandiweb-test`.`products` (
    `id` VARCHAR NOT NULL,
    `sku` VARCHAR NOT NULL,
    `name` VARCHAR NOT NULL,
    `price` DECIMAL NOT NULL,
    `type` VARCHAR NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`sku`)
) ENGINE = InnoDB;