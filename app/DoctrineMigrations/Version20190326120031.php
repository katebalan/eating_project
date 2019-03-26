<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326120031 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', first_name VARCHAR(255) DEFAULT NULL, second_name VARCHAR(255) DEFAULT NULL, age INT NOT NULL, gender TINYINT(1) NOT NULL, phone VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, energy_exchange DOUBLE PRECISION DEFAULT NULL, daily_kkal INT NOT NULL, daily_proteins DOUBLE PRECISION NOT NULL, daily_fats DOUBLE PRECISION NOT NULL, daily_carbohydrates DOUBLE PRECISION NOT NULL, current_kkal INT NOT NULL, current_proteins DOUBLE PRECISION NOT NULL, current_fats DOUBLE PRECISION NOT NULL, current_carbohydrates DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consumption (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, how_much INT NOT NULL, meals_of_the_day VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2CFF2DF9A76ED395 (user_id), INDEX IDX_2CFF2DF94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, file VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6A2CA10CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, kkal_per_5minutes INT NOT NULL, proteins_per_5minutes DOUBLE PRECISION NOT NULL, fats_per_5minutes DOUBLE PRECISION NOT NULL, carbohydrates_per_5minutes DOUBLE PRECISION NOT NULL, rating INT DEFAULT NULL, created_at DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, kkal_per_100gr INT NOT NULL, proteins_per_100gr DOUBLE PRECISION NOT NULL, fats_per_100gr DOUBLE PRECISION NOT NULL, carbohydrates_per_100gr DOUBLE PRECISION NOT NULL, rating INT DEFAULT NULL, created_at DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consumption ADD CONSTRAINT FK_2CFF2DF9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consumption ADD CONSTRAINT FK_2CFF2DF94584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consumption DROP FOREIGN KEY FK_2CFF2DF9A76ED395');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CA76ED395');
        $this->addSql('ALTER TABLE consumption DROP FOREIGN KEY FK_2CFF2DF94584665A');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE consumption');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE products');
    }
}
