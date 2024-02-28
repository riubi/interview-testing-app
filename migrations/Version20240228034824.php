<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228034824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates tables for questions and options in the testing system';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('questions');
        $table->addColumn('question_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('expression', 'text');
        $table->setPrimaryKey(['question_id']);

        $table = $schema->createTable('options');
        $table->addColumn('option_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('question_id', 'integer');
        $table->addColumn('expression', 'text');
        $table->setPrimaryKey(['option_id']);
        $table->addForeignKeyConstraint('questions', ['question_id'], ['question_id']);

        $table = $schema->createTable('test_results');
        $table->addColumn('test_result_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('correct_answers', 'integer');
        $table->addColumn('wrong_answers', 'integer');
        $table->setPrimaryKey(['test_result_id']);
    }

    public function down(Schema $schema): void
    {
        $schema
            ->dropTable('test_results')
            ->dropTable('options')
            ->dropTable('questions');
    }
}
