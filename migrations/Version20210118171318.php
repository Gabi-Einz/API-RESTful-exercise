<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118171318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alumno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curso (id INT AUTO_INCREMENT NOT NULL, profesor_id INT NOT NULL, materia_id INT NOT NULL, name VARCHAR(255) NOT NULL, fecha_inscripcion VARCHAR(255) DEFAULT NULL, INDEX IDX_CA3B40ECE52BD977 (profesor_id), INDEX IDX_CA3B40ECB54DBBCB (materia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curso_alumno (curso_id INT NOT NULL, alumno_id INT NOT NULL, INDEX IDX_E95F735487CB4A1F (curso_id), INDEX IDX_E95F7354FC28E5EE (alumno_id), PRIMARY KEY(curso_id, alumno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materia (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT FK_CA3B40ECE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesor (id)');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT FK_CA3B40ECB54DBBCB FOREIGN KEY (materia_id) REFERENCES materia (id)');
        $this->addSql('ALTER TABLE curso_alumno ADD CONSTRAINT FK_E95F735487CB4A1F FOREIGN KEY (curso_id) REFERENCES curso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curso_alumno ADD CONSTRAINT FK_E95F7354FC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso_alumno DROP FOREIGN KEY FK_E95F7354FC28E5EE');
        $this->addSql('ALTER TABLE curso_alumno DROP FOREIGN KEY FK_E95F735487CB4A1F');
        $this->addSql('ALTER TABLE curso DROP FOREIGN KEY FK_CA3B40ECB54DBBCB');
        $this->addSql('ALTER TABLE curso DROP FOREIGN KEY FK_CA3B40ECE52BD977');
        $this->addSql('DROP TABLE alumno');
        $this->addSql('DROP TABLE curso');
        $this->addSql('DROP TABLE curso_alumno');
        $this->addSql('DROP TABLE materia');
        $this->addSql('DROP TABLE profesor');
    }
}
