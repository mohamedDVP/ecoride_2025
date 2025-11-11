<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251111001002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuration_parametre (configuration_id INT NOT NULL, parametre_id INT NOT NULL, INDEX IDX_26C3BC1A73F32DD8 (configuration_id), INDEX IDX_26C3BC1A6358FF62 (parametre_id), PRIMARY KEY(configuration_id, parametre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configuration_parametre ADD CONSTRAINT FK_26C3BC1A73F32DD8 FOREIGN KEY (configuration_id) REFERENCES configuration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE configuration_parametre ADD CONSTRAINT FK_26C3BC1A6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE configuration ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE configuration ADD CONSTRAINT FK_A5E2A5D7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_A5E2A5D7FB88E14F ON configuration (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE configuration_parametre DROP FOREIGN KEY FK_26C3BC1A73F32DD8');
        $this->addSql('ALTER TABLE configuration_parametre DROP FOREIGN KEY FK_26C3BC1A6358FF62');
        $this->addSql('DROP TABLE configuration_parametre');
        $this->addSql('ALTER TABLE configuration DROP FOREIGN KEY FK_A5E2A5D7FB88E14F');
        $this->addSql('DROP INDEX IDX_A5E2A5D7FB88E14F ON configuration');
        $this->addSql('ALTER TABLE configuration DROP utilisateur_id');
    }
}
