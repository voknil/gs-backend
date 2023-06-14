<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127195643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE vacancy (id UUID NOT NULL, category_id UUID NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A9346CBD12469DE2 ON vacancy (category_id)');
        $this->addSql('COMMENT ON COLUMN vacancy.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN vacancy.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE vacancy_category (id UUID NOT NULL, title VARCHAR(255) NOT NULL, image UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN vacancy_category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN vacancy_category.image IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE vacancy ADD CONSTRAINT FK_A9346CBD12469DE2 FOREIGN KEY (category_id) REFERENCES vacancy_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vacancy DROP CONSTRAINT FK_A9346CBD12469DE2');
        $this->addSql('DROP TABLE vacancy');
        $this->addSql('DROP TABLE vacancy_category');
    }
}
