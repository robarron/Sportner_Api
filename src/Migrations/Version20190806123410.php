<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806123410 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image CHANGE pic2 pic2 VARCHAR(65535) DEFAULT NULL, CHANGE pic3 pic3 VARCHAR(65535) DEFAULT NULL, CHANGE pic4 pic4 VARCHAR(65535) DEFAULT NULL, CHANGE pic5 pic5 VARCHAR(65535) DEFAULT NULL, CHANGE pic6 pic6 VARCHAR(65535) DEFAULT NULL, CHANGE profil_pic profil_pic VARCHAR(65000) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD motivation VARCHAR(400) DEFAULT NULL, ADD sportCaractertics VARCHAR(400) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD level VARCHAR(255) DEFAULT NULL, ADD mondayBeginningHour TIME DEFAULT NULL, ADD mondayFinishHour TIME DEFAULT NULL, ADD tuedsayBeginningHour TIME DEFAULT NULL, ADD tuesdayFinishHour TIME DEFAULT NULL, ADD wednesdayBeginningHour TIME DEFAULT NULL, ADD wednesdayFinishHour TIME DEFAULT NULL, ADD thursdayBeginningHour TIME DEFAULT NULL, ADD thursdayFinishHour TIME DEFAULT NULL, ADD fridayBeginningHour TIME DEFAULT NULL, ADD fridayFinishHour TIME DEFAULT NULL, ADD saturdayBeginningHour TIME DEFAULT NULL, ADD saturdayFinishHour TIME DEFAULT NULL, ADD sundayBeginningHour TIME DEFAULT NULL, ADD sundayFinishHour TIME DEFAULT NULL');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
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
        $this->addSql('ALTER TABLE Image CHANGE profil_pic profil_pic MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic2 pic2 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic3 pic3 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic4 pic4 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic5 pic5 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic6 pic6 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE User DROP motivation, DROP sportCaractertics, DROP city, DROP level, DROP mondayBeginningHour, DROP mondayFinishHour, DROP tuedsayBeginningHour, DROP tuesdayFinishHour, DROP wednesdayBeginningHour, DROP wednesdayFinishHour, DROP thursdayBeginningHour, DROP thursdayFinishHour, DROP fridayBeginningHour, DROP fridayFinishHour, DROP saturdayBeginningHour, DROP saturdayFinishHour, DROP sundayBeginningHour, DROP sundayFinishHour');
    }
}
