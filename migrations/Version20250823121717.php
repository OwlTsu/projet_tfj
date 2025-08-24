<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250823121717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, sub_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, detail LONGTEXT NOT NULL, size VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, price VARCHAR(255) NOT NULL, image_one VARCHAR(255) DEFAULT NULL, image_two VARCHAR(255) DEFAULT NULL, image_three VARCHAR(255) DEFAULT NULL, INDEX IDX_BFDD316812469DE2 (category_id), INDEX IDX_BFDD3168F7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles ADD CONSTRAINT FK_BFDD316812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact CHANGE phone phone VARCHAR(255) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316812469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168F7BFE87C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE articles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sub_category
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact CHANGE phone phone VARCHAR(255) NOT NULL
        SQL);
    }
}
