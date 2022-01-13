<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113092745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis CHANGE date_creation date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE contract CHANGE debut_contrat debut_contrat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE fin_contrat fin_contrat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE annee annee DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis CHANGE date_creation date_creation DATE NOT NULL');
        $this->addSql('ALTER TABLE contract CHANGE debut_contrat debut_contrat DATE NOT NULL, CHANGE fin_contrat fin_contrat DATE NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE annee annee DATE DEFAULT NULL');
    }
}
