<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018114936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD surname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD company VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD gender VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD birthday DATE DEFAULT NULL');
    }


}
