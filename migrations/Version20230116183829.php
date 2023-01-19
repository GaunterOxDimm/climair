<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116183829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD categorie_article_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66EC5D4C30 FOREIGN KEY (categorie_article_id) REFERENCES categorie_article (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66EC5D4C30 ON article (categorie_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66EC5D4C30');
        $this->addSql('DROP INDEX IDX_23A0E66EC5D4C30 ON article');
        $this->addSql('ALTER TABLE article DROP categorie_article_id');
    }
}
