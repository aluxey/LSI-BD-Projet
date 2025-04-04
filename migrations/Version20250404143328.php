<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404143328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE description description VARCHAR(50) DEFAULT NULL, CHANGE date_event date_event DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_evenement CHANGE titre titre VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_projet CHANGE titre titre VARCHAR(50) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre CHANGE promo_id promo_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE prenom prenom VARCHAR(50) DEFAULT NULL, CHANGE role role VARCHAR(50) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE date_message date_message DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE date_message date_message DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projet CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE description description VARCHAR(50) DEFAULT NULL, CHANGE theme theme VARCHAR(50) DEFAULT NULL, CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE date_event date_event DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo CHANGE nom nom VARCHAR(50) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE nom nom VARCHAR(50) DEFAULT 'NULL', CHANGE description description VARCHAR(50) DEFAULT 'NULL', CHANGE date_event date_event DATE DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_evenement CHANGE titre titre VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_projet CHANGE titre titre VARCHAR(50) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre CHANGE promo_id promo_id INT NOT NULL, CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE role role VARCHAR(50) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement CHANGE message message VARCHAR(255) DEFAULT 'NULL', CHANGE date_message date_message DATE DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet CHANGE message message VARCHAR(255) DEFAULT 'NULL', CHANGE date_message date_message DATE DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT 'NULL' COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE projet CHANGE nom nom VARCHAR(50) DEFAULT 'NULL', CHANGE description description VARCHAR(50) DEFAULT 'NULL', CHANGE theme theme VARCHAR(50) DEFAULT 'NULL', CHANGE type type VARCHAR(50) DEFAULT 'NULL', CHANGE date_event date_event DATE DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE promo CHANGE nom nom VARCHAR(50) DEFAULT 'NULL'
        SQL);
    }
}
