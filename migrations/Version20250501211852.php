<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501211852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement ADD forum_evenement_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement ADD CONSTRAINT FK_619F6E28370ED954 FOREIGN KEY (forum_evenement_id) REFERENCES forum_evenement (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_619F6E28370ED954 ON message_evenement (forum_evenement_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement DROP FOREIGN KEY FK_619F6E28370ED954
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_619F6E28370ED954 ON message_evenement
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement DROP forum_evenement_id
        SQL);
    }
}
