<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228152606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, appartenir_id INT NOT NULL, nom_article VARCHAR(50) NOT NULL, prix_article DOUBLE PRECISION NOT NULL, img_article VARCHAR(255) NOT NULL, description_article LONGTEXT NOT NULL, INDEX IDX_23A0E66E977E148 (appartenir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_article (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, total_commande INT NOT NULL, INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, description_prestation LONGTEXT NOT NULL, img_prestation VARCHAR(255) NOT NULL, prix_prestation DOUBLE PRECISION NOT NULL, date_de_prestation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation_rdvprestation (prestation_id INT NOT NULL, rdvprestation_id INT NOT NULL, INDEX IDX_64625C369E45C554 (prestation_id), INDEX IDX_64625C36FFA3868A (rdvprestation_id), PRIMARY KEY(prestation_id, rdvprestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv_prestation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, date_rdv DATE NOT NULL, INDEX IDX_868354CAFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E977E148 FOREIGN KEY (appartenir_id) REFERENCES categorie_article (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE prestation_rdvprestation ADD CONSTRAINT FK_64625C369E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_rdvprestation ADD CONSTRAINT FK_64625C36FFA3868A FOREIGN KEY (rdvprestation_id) REFERENCES rdv_prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rdv_prestation ADD CONSTRAINT FK_868354CAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD integre_id INT NOT NULL, ADD correspond_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6A856768C FOREIGN KEY (integre_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE698DE379A FOREIGN KEY (correspond_id) REFERENCES prestation (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE6A856768C ON ligne_de_commande (integre_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7982ACE698DE379A ON ligne_de_commande (correspond_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6A856768C');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE698DE379A');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E977E148');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('ALTER TABLE prestation_rdvprestation DROP FOREIGN KEY FK_64625C369E45C554');
        $this->addSql('ALTER TABLE prestation_rdvprestation DROP FOREIGN KEY FK_64625C36FFA3868A');
        $this->addSql('ALTER TABLE rdv_prestation DROP FOREIGN KEY FK_868354CAFB88E14F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categorie_article');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE prestation_rdvprestation');
        $this->addSql('DROP TABLE rdv_prestation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_7982ACE6A856768C ON ligne_de_commande');
        $this->addSql('DROP INDEX UNIQ_7982ACE698DE379A ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP integre_id, DROP correspond_id');
    }
}
