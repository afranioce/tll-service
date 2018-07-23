<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180718233857 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE departamento (id INT AUTO_INCREMENT NOT NULL, criado_por_id INT NOT NULL, atualizado_por_id INT DEFAULT NULL, nome VARCHAR(100) NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, atualizado_em DATETIME DEFAULT NULL, INDEX IDX_40E497EBF42F4A03 (criado_por_id), INDEX IDX_40E497EB8447AA9A (atualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE funcionario (id INT AUTO_INCREMENT NOT NULL, departamento_id INT NOT NULL, criado_por_id INT NOT NULL, atualizado_por_id INT DEFAULT NULL, nome VARCHAR(200) NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, atualizado_em DATETIME DEFAULT NULL, INDEX IDX_7510A3CF5A91C08D (departamento_id), INDEX IDX_7510A3CFF42F4A03 (criado_por_id), INDEX IDX_7510A3CF8447AA9A (atualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimentacao (id INT AUTO_INCREMENT NOT NULL, funcionario_id INT NOT NULL, criado_por_id INT NOT NULL, atualizado_por_id INT DEFAULT NULL, descricao LONGTEXT DEFAULT NULL, valor NUMERIC(10, 2) NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, atualizado_em DATETIME DEFAULT NULL, INDEX IDX_C1BF366A642FEB76 (funcionario_id), INDEX IDX_C1BF366AF42F4A03 (criado_por_id), INDEX IDX_C1BF366A8447AA9A (atualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_2265B05D92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_2265B05DA0D96FBF (email_canonical), UNIQUE INDEX UNIQ_2265B05DC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departamento ADD CONSTRAINT FK_40E497EBF42F4A03 FOREIGN KEY (criado_por_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE departamento ADD CONSTRAINT FK_40E497EB8447AA9A FOREIGN KEY (atualizado_por_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE funcionario ADD CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)');
        $this->addSql('ALTER TABLE funcionario ADD CONSTRAINT FK_7510A3CFF42F4A03 FOREIGN KEY (criado_por_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE funcionario ADD CONSTRAINT FK_7510A3CF8447AA9A FOREIGN KEY (atualizado_por_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE movimentacao ADD CONSTRAINT FK_C1BF366A642FEB76 FOREIGN KEY (funcionario_id) REFERENCES funcionario (id)');
        $this->addSql('ALTER TABLE movimentacao ADD CONSTRAINT FK_C1BF366AF42F4A03 FOREIGN KEY (criado_por_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE movimentacao ADD CONSTRAINT FK_C1BF366A8447AA9A FOREIGN KEY (atualizado_por_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE funcionario DROP FOREIGN KEY FK_7510A3CF5A91C08D');
        $this->addSql('ALTER TABLE movimentacao DROP FOREIGN KEY FK_C1BF366A642FEB76');
        $this->addSql('ALTER TABLE departamento DROP FOREIGN KEY FK_40E497EBF42F4A03');
        $this->addSql('ALTER TABLE departamento DROP FOREIGN KEY FK_40E497EB8447AA9A');
        $this->addSql('ALTER TABLE funcionario DROP FOREIGN KEY FK_7510A3CFF42F4A03');
        $this->addSql('ALTER TABLE funcionario DROP FOREIGN KEY FK_7510A3CF8447AA9A');
        $this->addSql('ALTER TABLE movimentacao DROP FOREIGN KEY FK_C1BF366AF42F4A03');
        $this->addSql('ALTER TABLE movimentacao DROP FOREIGN KEY FK_C1BF366A8447AA9A');
        $this->addSql('DROP TABLE departamento');
        $this->addSql('DROP TABLE funcionario');
        $this->addSql('DROP TABLE movimentacao');
        $this->addSql('DROP TABLE usuario');
    }
}
