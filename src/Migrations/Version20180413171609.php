<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413171609 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE card_subcategory (card_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_EA08FBD24ACC9A20 (card_id), INDEX IDX_EA08FBD2F7BFE87C (sub_category_id), PRIMARY KEY(card_id, sub_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_subcategory ADD CONSTRAINT FK_EA08FBD24ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_subcategory ADD CONSTRAINT FK_EA08FBD2F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3EF1B3128');
        $this->addSql('DROP INDEX IDX_161498D3EF1B3128 ON card');
        $this->addSql('ALTER TABLE card DROP subcategories_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE card_subcategory');
        $this->addSql('ALTER TABLE card ADD subcategories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3EF1B3128 FOREIGN KEY (subcategories_id) REFERENCES sub_category (id)');
        $this->addSql('CREATE INDEX IDX_161498D3EF1B3128 ON card (subcategories_id)');
    }
}
