<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111193604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, formations_id INT NOT NULL, entreprises_id INT NOT NULL, id_stage VARCHAR(255) NOT NULL, intitule VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_debut VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, competences_requises VARCHAR(255) NOT NULL, experience_requise VARCHAR(255) DEFAULT NULL, INDEX IDX_C27C93693BF5B0C2 (formations_id), INDEX IDX_C27C9369A70A18EC (entreprises_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93693BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A70A18EC FOREIGN KEY (entreprises_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stage');
    }
}
