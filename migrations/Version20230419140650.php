<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419140650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo_gallery (id UUID NOT NULL, id_media_file UUID NOT NULL, id_organization UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C8A281D34584665A ON photo_gallery (id_organization)');
        $this->addSql('ALTER TABLE photo_gallery ADD CONSTRAINT FK_C8A281D3F5B7AF75 FOREIGN KEY (id_media_file) REFERENCES media_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photo_gallery ADD CONSTRAINT FK_C8A281D34584665A FOREIGN KEY (id_organization) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photo_gallery');
    }
}
