<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321101803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E744CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id)');
        $this->addSql('CREATE INDEX IDX_C82E744CC8505A ON clients (offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E744CC8505A');
        $this->addSql('DROP INDEX IDX_C82E744CC8505A ON clients');
        $this->addSql('ALTER TABLE clients DROP offre_id');
    }
}
