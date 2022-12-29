<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228163940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv_prestation ADD prendre_rdv_id INT NOT NULL');
        $this->addSql('ALTER TABLE rdv_prestation ADD CONSTRAINT FK_868354CAE5EC4396 FOREIGN KEY (prendre_rdv_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_868354CAE5EC4396 ON rdv_prestation (prendre_rdv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv_prestation DROP FOREIGN KEY FK_868354CAE5EC4396');
        $this->addSql('DROP INDEX IDX_868354CAE5EC4396 ON rdv_prestation');
        $this->addSql('ALTER TABLE rdv_prestation DROP prendre_rdv_id');
    }
}
