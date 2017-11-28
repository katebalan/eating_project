<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171128143450 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consumption DROP FOREIGN KEY FK_2CFF2DF9DE18E50B');
        $this->addSql('DROP INDEX IDX_2CFF2DF9DE18E50B ON consumption');
        $this->addSql('ALTER TABLE consumption CHANGE product_id_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE consumption ADD CONSTRAINT FK_2CFF2DF94584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_2CFF2DF94584665A ON consumption (product_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consumption DROP FOREIGN KEY FK_2CFF2DF94584665A');
        $this->addSql('DROP INDEX IDX_2CFF2DF94584665A ON consumption');
        $this->addSql('ALTER TABLE consumption CHANGE product_id product_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE consumption ADD CONSTRAINT FK_2CFF2DF9DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_2CFF2DF9DE18E50B ON consumption (product_id_id)');
    }
}
