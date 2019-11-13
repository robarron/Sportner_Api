<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804071046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image ADD profilPic VARCHAR(65000) DEFAULT NULL, ADD pic2 VARCHAR(65535) DEFAULT NULL, ADD pic3 VARCHAR(65535) DEFAULT NULL, ADD pic4 VARCHAR(65535) DEFAULT NULL, ADD pic5 VARCHAR(65535) DEFAULT NULL, ADD pic6 VARCHAR(65535) DEFAULT NULL, CHANGE base64 base64 VARCHAR(65535) NOT NULL');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class(191))');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username(191))');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class(191), version)');
        $this->addSql('ALTER TABLE Image DROP profilPic, DROP pic2, DROP pic3, DROP pic4, DROP pic5, DROP pic6, CHANGE base64 base64 MEDIUMTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
