<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102123206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestation_rdvprestation DROP FOREIGN KEY FK_64625C36FFA3868A');
        $this->addSql('ALTER TABLE prestation_rdvprestation DROP FOREIGN KEY FK_64625C369E45C554');
        $this->addSql('ALTER TABLE rdv_prestation DROP FOREIGN KEY FK_868354CAE5EC4396');
        $this->addSql('DROP TABLE prestation_rdvprestation');
        $this->addSql('DROP TABLE rdv_prestation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestation_rdvprestation (prestation_id INT NOT NULL, rdvprestation_id INT NOT NULL, INDEX IDX_64625C369E45C554 (prestation_id), INDEX IDX_64625C36FFA3868A (rdvprestation_id), PRIMARY KEY(prestation_id, rdvprestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rdv_prestation (id INT AUTO_INCREMENT NOT NULL, prendre_rdv_id INT NOT NULL, date_rdv DATE NOT NULL, INDEX IDX_868354CAE5EC4396 (prendre_rdv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE prestation_rdvprestation ADD CONSTRAINT FK_64625C36FFA3868A FOREIGN KEY (rdvprestation_id) REFERENCES rdv_prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_rdvprestation ADD CONSTRAINT FK_64625C369E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rdv_prestation ADD CONSTRAINT FK_868354CAE5EC4396 FOREIGN KEY (prendre_rdv_id) REFERENCES utilisateur (id)');
    }
}
