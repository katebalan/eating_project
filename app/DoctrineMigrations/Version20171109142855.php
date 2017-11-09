<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171109142855 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD rating INT DEFAULT NULL, DROP activity, CHANGE weight weight DOUBLE PRECISION NOT NULL, CHANGE height height DOUBLE PRECISION NOT NULL, CHANGE daily_proteins daily_proteins DOUBLE PRECISION NOT NULL, CHANGE daily_fats daily_fats DOUBLE PRECISION NOT NULL, CHANGE daily_carbohydrates daily_carbohydrates DOUBLE PRECISION NOT NULL, CHANGE current_proteins current_proteins DOUBLE PRECISION NOT NULL, CHANGE current_fats current_fats DOUBLE PRECISION NOT NULL, CHANGE current_carbohydrates current_carbohydrates DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE products CHANGE proteins_per_100gr proteins_per_100gr DOUBLE PRECISION NOT NULL, CHANGE fats_per_100gr fats_per_100gr DOUBLE PRECISION NOT NULL, CHANGE carbohydrates_per_100gr carbohydrates_per_100gr DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE activity CHANGE proteins_per_5minutes proteins_per_5minutes DOUBLE PRECISION NOT NULL, CHANGE fats_per_5minutes fats_per_5minutes DOUBLE PRECISION NOT NULL, CHANGE carbohydrates_per_5minutes carbohydrates_per_5minutes DOUBLE PRECISION NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity CHANGE proteins_per_5minutes proteins_per_5minutes INT NOT NULL, CHANGE fats_per_5minutes fats_per_5minutes INT NOT NULL, CHANGE carbohydrates_per_5minutes carbohydrates_per_5minutes INT NOT NULL');
        $this->addSql('ALTER TABLE products CHANGE proteins_per_100gr proteins_per_100gr INT NOT NULL, CHANGE fats_per_100gr fats_per_100gr INT NOT NULL, CHANGE carbohydrates_per_100gr carbohydrates_per_100gr INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD activity INT NOT NULL, DROP rating, CHANGE weight weight INT NOT NULL, CHANGE height height INT NOT NULL, CHANGE daily_proteins daily_proteins INT NOT NULL, CHANGE daily_fats daily_fats INT NOT NULL, CHANGE daily_carbohydrates daily_carbohydrates INT NOT NULL, CHANGE current_proteins current_proteins INT NOT NULL, CHANGE current_fats current_fats INT NOT NULL, CHANGE current_carbohydrates current_carbohydrates INT NOT NULL');
    }
}
