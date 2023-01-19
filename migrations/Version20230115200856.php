<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115200856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, total_commande DOUBLE PRECISION DEFAULT NULL, date_commande DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6A856768C');
        $this->addSql('DROP INDEX IDX_7982ACE6A856768C ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP integre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('ALTER TABLE ligne_de_commande ADD integre_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6A856768C FOREIGN KEY (integre_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE6A856768C ON ligne_de_commande (integre_id)');
    }
}
