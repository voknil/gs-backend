<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223191036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD phone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD about_me TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD vk VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD facebook VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD instagram VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD telegram VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER gender TYPE TEXT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP country');
        $this->addSql('ALTER TABLE "user" DROP city');
        $this->addSql('ALTER TABLE "user" DROP phone');
        $this->addSql('ALTER TABLE "user" DROP about_me');
        $this->addSql('ALTER TABLE "user" DROP vk');
        $this->addSql('ALTER TABLE "user" DROP facebook');
        $this->addSql('ALTER TABLE "user" DROP instagram');
        $this->addSql('ALTER TABLE "user" DROP telegram');
        $this->addSql('ALTER TABLE "user" ALTER gender TYPE TEXT');
    }
}
