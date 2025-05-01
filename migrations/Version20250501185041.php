<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501185041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_event DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE forum_evenement (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, titre VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_356FEC48FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE forum_projet (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, titre VARCHAR(50) DEFAULT NULL, INDEX IDX_48BAAF78C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, role VARCHAR(50) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F6B4FB29E7927C74 (email), INDEX IDX_F6B4FB29D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE membre_projet (membre_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_CA1C09106A99F74A (membre_id), INDEX IDX_CA1C0910C18272 (projet_id), PRIMARY KEY(membre_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message_evenement (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, message VARCHAR(255) DEFAULT NULL, date_message DATE DEFAULT NULL, INDEX IDX_619F6E286A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message_projet (id INT AUTO_INCREMENT NOT NULL, forum_projet_id INT NOT NULL, membre_id INT NOT NULL, message VARCHAR(255) DEFAULT NULL, date_message DATE DEFAULT NULL, INDEX IDX_673201A63E880624 (forum_projet_id), INDEX IDX_673201A66A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, theme VARCHAR(50) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, date_event DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_evenement ADD CONSTRAINT FK_356FEC48FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_projet ADD CONSTRAINT FK_48BAAF78C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre_projet ADD CONSTRAINT FK_CA1C09106A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre_projet ADD CONSTRAINT FK_CA1C0910C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement ADD CONSTRAINT FK_619F6E286A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet ADD CONSTRAINT FK_673201A63E880624 FOREIGN KEY (forum_projet_id) REFERENCES forum_projet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet ADD CONSTRAINT FK_673201A66A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_evenement DROP FOREIGN KEY FK_356FEC48FD02F13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum_projet DROP FOREIGN KEY FK_48BAAF78C18272
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29D0C07AFF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre_projet DROP FOREIGN KEY FK_CA1C09106A99F74A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membre_projet DROP FOREIGN KEY FK_CA1C0910C18272
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_evenement DROP FOREIGN KEY FK_619F6E286A99F74A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet DROP FOREIGN KEY FK_673201A63E880624
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_projet DROP FOREIGN KEY FK_673201A66A99F74A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE forum_evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE forum_projet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE membre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE membre_projet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message_evenement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message_projet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE projet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE promo
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
