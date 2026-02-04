<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260204190640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE event_store (
            id BIGSERIAL PRIMARY KEY,
            event_type VARCHAR(255) NOT NULL,
            payload JSONB NOT NULL,
            occurred_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
        )'
        );

        $this->addSql(
            'CREATE INDEX idx_event_store_event_type ON event_store (event_type)'
        );

        $this->addSql(
            'CREATE INDEX idx_event_store_occurred_at ON event_store (occurred_at)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event_store');
    }
}
