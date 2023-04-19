<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419090534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_file (id UUID NOT NULL, title VARCHAR(180) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, mime_type VARCHAR(255) NOT NULL, size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FD8E9C32B36786B ON media_file (title)');
        $this->addSql('COMMENT ON COLUMN media_file.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE organization ALTER address SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER type SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER website SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER vk SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER facebook SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER instagram SET NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER telegram SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER gender TYPE TEXT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE media_file');
        $this->addSql('ALTER TABLE organization ALTER address DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER type DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER website DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER vk DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER facebook DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER instagram DROP NOT NULL');
        $this->addSql('ALTER TABLE organization ALTER telegram DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER gender TYPE TEXT');
    }
}
