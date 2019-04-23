<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190419191301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('DROP INDEX IDX_C53D045FA76ED395 ON image');
        $this->addSql('ALTER TABLE image ADD image VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, DROP user_id, DROP path, DROP name, DROP mime_type, DROP size, DROP public_path');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image ADD user_id INT DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD mime_type VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD size NUMERIC(10, 0) DEFAULT NULL, ADD public_path VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP image, DROP description');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA76ED395 ON image (user_id)');
    }
}
