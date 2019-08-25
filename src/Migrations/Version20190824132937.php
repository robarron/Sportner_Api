<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190824132937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE UserLikeComment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, feedComment_id INT NOT NULL, INDEX IDX_5656185CA76ED395 (user_id), INDEX IDX_5656185CB23A3C02 (feedComment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserLikeFeed (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, feed_id INT NOT NULL, INDEX IDX_A09D165FA76ED395 (user_id), INDEX IDX_A09D165F51A5BC03 (feed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE UserLikeComment ADD CONSTRAINT FK_5656185CA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE UserLikeComment ADD CONSTRAINT FK_5656185CB23A3C02 FOREIGN KEY (feedComment_id) REFERENCES FeedComment (id)');
        $this->addSql('ALTER TABLE UserLikeFeed ADD CONSTRAINT FK_A09D165FA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE UserLikeFeed ADD CONSTRAINT FK_A09D165F51A5BC03 FOREIGN KEY (feed_id) REFERENCES Feed (id)');
        $this->addSql('ALTER TABLE image CHANGE pic2 pic2 VARCHAR(65535) DEFAULT NULL, CHANGE pic3 pic3 VARCHAR(65535) DEFAULT NULL, CHANGE pic4 pic4 VARCHAR(65535) DEFAULT NULL, CHANGE pic5 pic5 VARCHAR(65535) DEFAULT NULL, CHANGE pic6 pic6 VARCHAR(65535) DEFAULT NULL, CHANGE profil_pic profil_pic VARCHAR(65000) DEFAULT NULL');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE UserLikeComment');
        $this->addSql('DROP TABLE UserLikeFeed');
        $this->addSql('DROP INDEX log_class_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_user_lookup_idx ON ext_log_entries');
        $this->addSql('DROP INDEX log_version_lookup_idx ON ext_log_entries');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class(191))');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username(191))');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class(191), version)');
        $this->addSql('ALTER TABLE Image CHANGE profil_pic profil_pic MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic2 pic2 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic3 pic3 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic4 pic4 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic5 pic5 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE pic6 pic6 MEDIUMTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
