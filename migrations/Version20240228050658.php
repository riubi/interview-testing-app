<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228050658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds initial questions and answers to the database.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO questions (question_id, expression) VALUES (1, '1 + 1 = ');");
        $this->addSql("INSERT INTO questions (question_id, expression) VALUES (2, '2 * 2 = ');");
        $this->addSql("INSERT INTO questions (question_id, expression) VALUES (3, '(6 / 2 + 1) * 0 = ');");

        $this->addSql("INSERT INTO options (question_id, expression) VALUES (1, '3 + 3');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (1, '2 * 1');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (1, '0');");

        $this->addSql("INSERT INTO options (question_id, expression) VALUES (2, '4');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (2, '3 + 1');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (2, '10 - 6');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (2, '4');");

        $this->addSql("INSERT INTO options (question_id, expression) VALUES (3, '3 + 1 - 4');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (3, '5 - 6');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (3, '18 / 2');");
        $this->addSql("INSERT INTO options (question_id, expression) VALUES (3, '2 / 2 - 3');");
    }

    public function down(Schema $schema): void
    {
    }
}
