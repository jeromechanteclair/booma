<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413154928 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sub_category_card (sub_category_id INT NOT NULL, card_id INT NOT NULL, INDEX IDX_5222254AF7BFE87C (sub_category_id), INDEX IDX_5222254A4ACC9A20 (card_id), PRIMARY KEY(sub_category_id, card_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_category_card ADD CONSTRAINT FK_5222254AF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category_card ADD CONSTRAINT FK_5222254A4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D312469DE2');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D35DC6FE57');
        $this->addSql('DROP INDEX IDX_161498D312469DE2 ON card');
        $this->addSql('DROP INDEX IDX_161498D35DC6FE57 ON card');
        $this->addSql('ALTER TABLE card ADD subcategories_id INT DEFAULT NULL, DROP category_id, DROP subcategory_id');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3EF1B3128 FOREIGN KEY (subcategories_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_161498D3EF1B3128 ON card (subcategories_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sub_category_card');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3EF1B3128');
        $this->addSql('DROP INDEX IDX_161498D3EF1B3128 ON card');
        $this->addSql('ALTER TABLE card ADD subcategory_id INT DEFAULT NULL, CHANGE subcategories_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D35DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_161498D312469DE2 ON card (category_id)');
        $this->addSql('CREATE INDEX IDX_161498D35DC6FE57 ON card (subcategory_id)');
    }
}
