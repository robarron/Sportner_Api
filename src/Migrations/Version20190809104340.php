<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190809104340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE GenderSearch (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserParameters (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, localisation LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', maxDistance INT NOT NULL, minAgeSearch INT NOT NULL, maxAgeSearch INT NOT NULL, displayProfil TINYINT(1) NOT NULL, displayPic TINYINT(1) NOT NULL, displayMotivations TINYINT(1) NOT NULL, displayCaracSportives TINYINT(1) NOT NULL, displayDispo TINYINT(1) NOT NULL, displayLevel TINYINT(1) NOT NULL, notifMatch TINYINT(1) NOT NULL, notifMessage TINYINT(1) NOT NULL, notifMaj TINYINT(1) NOT NULL, genderSearch_id INT NOT NULL, UNIQUE INDEX UNIQ_C9D61F0FA76ED395 (user_id), INDEX IDX_C9D61F0FB13B0B8 (genderSearch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE UserParameters ADD CONSTRAINT FK_C9D61F0FA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE UserParameters ADD CONSTRAINT FK_C9D61F0FB13B0B8 FOREIGN KEY (genderSearch_id) REFERENCES GenderSearch (id)');
        $this->addSql('ALTER TABLE image CHANGE pic2 pic2 VARCHAR(65535) DEFAULT NULL, CHANGE pic3 pic3 VARCHAR(65535) DEFAULT NULL, CHANGE pic4 pic4 VARCHAR(65535) DEFAULT NULL, CHANGE pic5 pic5 VARCHAR(65535) DEFAULT NULL, CHANGE pic6 pic6 VARCHAR(65535) DEFAULT NULL, CHANGE profil_pic profil_pic VARCHAR(65000) DEFAULT NULL');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UserParameters DROP FOREIGN KEY FK_C9D61F0FB13B0B8');
        $this->addSql('DROP TABLE GenderSearch');
        $this->addSql('DROP TABLE UserParameters');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class(191))');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username(191))');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class(191), version)');
        $this->addSql('ALTER TABLE Image CHANGE profil_pic profil_pic MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic2 pic2 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic3 pic3 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic4 pic4 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic5 pic5 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic6 pic6 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
