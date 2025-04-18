CREATE TABLE IF NOT EXISTS `User` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `CPF` VARCHAR(90) NOT NULL,
  `Nome` VARCHAR(90) NOT NULL,
  `Email` VARCHAR(90) NOT NULL,
  `Celular` VARCHAR(45) NOT NULL,
  `Senha` VARCHAR(45) NOT NULL,
  `Pontos` DOUBLE NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `NotaFiscal`.`Estabelecimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Estabelecimento` (
  `idEstabelecimento` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(45) NOT NULL,
  `Local` VARCHAR(45) NOT NULL,
  `CNPJ` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEstabelecimento`),
  UNIQUE INDEX `CNPJ_UNIQUE` (`CNPJ` ASC) VISIBLE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `NotaFiscal`.`Compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Compra` (
  `idCompra` INT NOT NULL AUTO_INCREMENT,
  `Valor` DOUBLE NOT NULL,
  `Data` DATE NOT NULL,
  `Compra_User` INT NOT NULL,
  `Compra_Estabelecimento` INT NOT NULL,
  PRIMARY KEY (`idCompra`),
  INDEX `fk_Compra_User_idx` (`Compra_User` ASC) VISIBLE,
  INDEX `fk_Compra_Estabelecimento1_idx` (`Compra_Estabelecimento` ASC) VISIBLE,
  CONSTRAINT `fk_Compra_User`
    FOREIGN KEY (`Compra_User`)
    REFERENCES `User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Compra_Estabelecimento1`
    FOREIGN KEY (`Compra_Estabelecimento`)
    REFERENCES `Estabelecimento` (`idEstabelecimento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `NotaFiscal`.`ADM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ADM` (
  `idADM` INT NOT NULL AUTO_INCREMENT,
  `CPF` VARCHAR(90) NOT NULL,
  `Nome` VARCHAR(90) NOT NULL,
  `Email` VARCHAR(90) NOT NULL,
  `Celular` VARCHAR(45) NOT NULL,
  `Senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idADM`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO ADM (CPF, Nome, Email, Celular, Senha) VALUES
('15161444657', 'Felipe Mendes', 'felipe.davila.bh@gmail.com', '31971740540', 'robin'),
('14578455856', 'Maria Eduarda', 'duda@gmail.com', '31975489526', '123');

INSERT INTO Estabelecimento (Nome, Local, CNPJ) VALUES
('CAIXA', 'BH', '12.345.678/0001-90'),
('Loterica Green', 'SP', '98.765.432/0001-01');

INSERT INTO User (Nome, Email, Celular, Senha, CPF, Pontos) VALUES ('Marcio Fantini', 'mf@gmail.com', '31999555724', '123', 'cpf', 0);