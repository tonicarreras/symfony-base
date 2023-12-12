<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231128124054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the domain_events table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE domain_events (
                id VARCHAR(255) NOT NULL,
                aggregate_id VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                body TEXT NOT NULL,
                occurred_on DATETIME NOT NULL,
                PRIMARY KEY (id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE domain_events');
    }
}
