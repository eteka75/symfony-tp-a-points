<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411202618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, create_at DATE NOT NULL)');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, groupe_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, CONSTRAINT FK_FCEC9EF7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF7A45358C ON personne (groupe_id)');
        $this->addSql('CREATE TABLE point (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER DEFAULT NULL, point INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_B7A5F324A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B7A5F324A21BD112 ON point (personne_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE point');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
