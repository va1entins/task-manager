<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260204200547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS event_store (
            id BIGSERIAL PRIMARY KEY,
            event_type VARCHAR(255) NOT NULL,
            payload JSONB NOT NULL,
            occurred_at TIMESTAMP WITHOUT TIME ZONE NOT NULL
        )'
        );
    }


    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS event_store');
    }
}
