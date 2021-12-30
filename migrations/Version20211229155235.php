<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229155235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_detail_product (order_detail_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_DCF554C864577843 (order_detail_id), INDEX IDX_DCF554C84584665A (product_id), PRIMARY KEY(order_detail_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_detail_product ADD CONSTRAINT FK_DCF554C864577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_detail_product ADD CONSTRAINT FK_DCF554C84584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64577843');
        $this->addSql('DROP INDEX IDX_D34A04AD64577843 ON product');
        $this->addSql('ALTER TABLE product DROP order_detail_id, CHANGE product_image product_image VARCHAR(255) DEFAULT NULL, CHANGE product_description product_description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_detail_product');
        $this->addSql('ALTER TABLE product ADD order_detail_id INT DEFAULT NULL, CHANGE product_image product_image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE product_description product_description DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D34A04AD64577843 ON product (order_detail_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
