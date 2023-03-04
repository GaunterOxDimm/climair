<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303151039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, prestation_id INT DEFAULT NULL, date_rdv DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_10C31F86FB88E14F (utilisateur_id), INDEX IDX_10C31F869E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F869E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE prestation DROP date_rdv');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86FB88E14F');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F869E45C554');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('ALTER TABLE prestation ADD date_rdv DATETIME NOT NULL');
    }
}
