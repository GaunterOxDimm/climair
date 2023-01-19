<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116185623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE698DE379A');
        $this->addSql('DROP INDEX UNIQ_7982ACE698DE379A ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP correspond_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande ADD correspond_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE698DE379A FOREIGN KEY (correspond_id) REFERENCES prestation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7982ACE698DE379A ON ligne_de_commande (correspond_id)');
    }
}
