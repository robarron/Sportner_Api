<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820081814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE UserMatch (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, second_user_id INT NOT NULL, INDEX IDX_1ECF5470A76ED395 (user_id), INDEX IDX_1ECF5470B02C53F8 (second_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE UserMatch ADD CONSTRAINT FK_1ECF5470A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE UserMatch ADD CONSTRAINT FK_1ECF5470B02C53F8 FOREIGN KEY (second_user_id) REFERENCES User (id)');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('ALTER TABLE image CHANGE pic2 pic2 VARCHAR(65535) DEFAULT NULL, CHANGE pic3 pic3 VARCHAR(65535) DEFAULT NULL, CHANGE pic4 pic4 VARCHAR(65535) DEFAULT NULL, CHANGE pic5 pic5 VARCHAR(65535) DEFAULT NULL, CHANGE pic6 pic6 VARCHAR(65535) DEFAULT NULL, CHANGE profil_pic profil_pic VARCHAR(65000) DEFAULT NULL');
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

        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, second_user_id INT NOT NULL, INDEX IDX_BB9AEA01B02C53F8 (second_user_id), INDEX IDX_BB9AEA01A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_BB9AEA01A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_BB9AEA01B02C53F8 FOREIGN KEY (second_user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE UserMatch');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class(191))');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username(191))');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class(191), version)');
        $this->addSql('ALTER TABLE Image CHANGE profil_pic profil_pic MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic2 pic2 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic3 pic3 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic4 pic4 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic5 pic5 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic6 pic6 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
