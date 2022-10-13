<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013092926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD surname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD company VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD birthday DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD location VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP name');
        $this->addSql('ALTER TABLE "user" DROP surname');
        $this->addSql('ALTER TABLE "user" DROP company');
        $this->addSql('ALTER TABLE "user" DROP avatar');
        $this->addSql('ALTER TABLE "user" DROP birthday');
        $this->addSql('ALTER TABLE "user" DROP location');
    }
}
