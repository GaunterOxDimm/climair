<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116174850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E977E148');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F173F79A');
        $this->addSql('DROP INDEX UNIQ_23A0E66F173F79A ON article');
        $this->addSql('DROP INDEX IDX_23A0E66E977E148 ON article');
        $this->addSql('ALTER TABLE article DROP appartenir_id, DROP correspondance_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD appartenir_id INT NOT NULL, ADD correspondance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E977E148 FOREIGN KEY (appartenir_id) REFERENCES categorie_article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F173F79A FOREIGN KEY (correspondance_id) REFERENCES ligne_de_commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66F173F79A ON article (correspondance_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66E977E148 ON article (appartenir_id)');
    }
}
