<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328094532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD website VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD vk VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD facebook VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD instagram VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE organization ADD telegram VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization DROP address');
        $this->addSql('ALTER TABLE organization DROP type');
        $this->addSql('ALTER TABLE organization DROP website');
        $this->addSql('ALTER TABLE organization DROP vk');
        $this->addSql('ALTER TABLE organization DROP facebook');
        $this->addSql('ALTER TABLE organization DROP instagram');
        $this->addSql('ALTER TABLE organization DROP telegram');
    }
}
