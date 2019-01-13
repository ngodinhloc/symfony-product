<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190113224316 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE TABLE product (
                            id INT(9) NOT NULL  AUTO_INCREMENT,
                            name varchar(250) NOT NULL,
                            picture varchar(500) NOT NULL,
                            price float NOT NULL,
                            description MEDIUMTEXT NOT NULL,
                            PRIMARY KEY (id),
                            KEY `name`(name),
                            KEY `price`(price)
                            )");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
