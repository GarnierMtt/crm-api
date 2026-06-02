<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260601131750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE criticites (id SERIAL NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE incidents (id SERIAL NOT NULL, fk_criticites_id INT NOT NULL, fk_liens_fibre_id INT DEFAULT NULL, fk_materiels_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, statut VARCHAR(255) NOT NULL, date_detection DATE NOT NULL, date_resolution DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E65135D0552C2ACF ON incidents (fk_criticites_id)');
        $this->addSql('CREATE INDEX IDX_E65135D0D241EE61 ON incidents (fk_liens_fibre_id)');
        $this->addSql('CREATE INDEX IDX_E65135D080D3894F ON incidents (fk_materiels_id)');
        $this->addSql('CREATE TABLE incidents_utilisateurs (incidents_id INT NOT NULL, utilisateurs_id INT NOT NULL, PRIMARY KEY(incidents_id, utilisateurs_id))');
        $this->addSql('CREATE INDEX IDX_B5867F5755955332 ON incidents_utilisateurs (incidents_id)');
        $this->addSql('CREATE INDEX IDX_B5867F571E969C5 ON incidents_utilisateurs (utilisateurs_id)');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D0552C2ACF FOREIGN KEY (fk_criticites_id) REFERENCES criticites (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D0D241EE61 FOREIGN KEY (fk_liens_fibre_id) REFERENCES liens_fibre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D080D3894F FOREIGN KEY (fk_materiels_id) REFERENCES materiels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents_utilisateurs ADD CONSTRAINT FK_B5867F5755955332 FOREIGN KEY (incidents_id) REFERENCES incidents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents_utilisateurs ADD CONSTRAINT FK_B5867F571E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE incidents DROP CONSTRAINT FK_E65135D0552C2ACF');
        $this->addSql('ALTER TABLE incidents DROP CONSTRAINT FK_E65135D0D241EE61');
        $this->addSql('ALTER TABLE incidents DROP CONSTRAINT FK_E65135D080D3894F');
        $this->addSql('ALTER TABLE incidents_utilisateurs DROP CONSTRAINT FK_B5867F5755955332');
        $this->addSql('ALTER TABLE incidents_utilisateurs DROP CONSTRAINT FK_B5867F571E969C5');
        $this->addSql('DROP TABLE criticites');
        $this->addSql('DROP TABLE incidents');
        $this->addSql('DROP TABLE incidents_utilisateurs');
    }
}
