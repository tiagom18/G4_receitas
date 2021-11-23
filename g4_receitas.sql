-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Nov-2021 às 03:09
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `g4_receitas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_cargo`
--

CREATE TABLE `g4_cargo` (
  `id_Cargo` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_cargo`
--

INSERT INTO `g4_cargo` (`id_Cargo`, `nome`) VALUES
(1, 'cozinheiro'),
(2, 'chefe'),
(3, 'editor'),
(4, 'provador'),
(5, 'estagiario'),
(6, 'teste1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_categoria`
--

CREATE TABLE `g4_categoria` (
  `id_Categoria` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_categoria`
--

INSERT INTO `g4_categoria` (`id_Categoria`, `descricao`) VALUES
(1, 'doces'),
(2, 'salgados'),
(3, 'carnes'),
(4, 'massas'),
(5, 'assados'),
(6, 'fritos'),
(7, 'teste1'),
(11, 'Bebida'),
(12, 'Bolos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_composicao`
--

CREATE TABLE `g4_composicao` (
  `id_Composicao` int(11) NOT NULL,
  `qtde_ingrediente` varchar(45) NOT NULL,
  `id_Ingrediente` int(11) NOT NULL,
  `id_Medida` int(11) NOT NULL,
  `id_Receita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_composicao`
--

INSERT INTO `g4_composicao` (`id_Composicao`, `qtde_ingrediente`, `id_Ingrediente`, `id_Medida`, `id_Receita`) VALUES
(1, '5', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_degustacao`
--

CREATE TABLE `g4_degustacao` (
  `id_Degustacao` int(11) NOT NULL,
  `nota` varchar(45) NOT NULL,
  `data_nota` date NOT NULL,
  `id_Funcionario` int(11) NOT NULL,
  `id_Receita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_degustacao`
--

INSERT INTO `g4_degustacao` (`id_Degustacao`, `nota`, `data_nota`, `id_Funcionario`, `id_Receita`) VALUES
(5, '10', '2021-11-11', 6, 1),
(7, '2021-11-11', '2021-11-11', 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_funcionario`
--

CREATE TABLE `g4_funcionario` (
  `id_Funcionario` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `rg` char(15) NOT NULL,
  `data_ingresso` date NOT NULL,
  `nome_fantasia` varchar(20) DEFAULT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `id_Cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_funcionario`
--

INSERT INTO `g4_funcionario` (`id_Funcionario`, `nome`, `rg`, `data_ingresso`, `nome_fantasia`, `usuario`, `senha`, `id_Cargo`) VALUES
(1, 'ana', '1234567', '2021-11-11', 'aninha', 'ana1', '321', 6),
(2, 'teste1', '1234567', '2021-11-11', 'teste', 'teste', '123', 6),
(6, 'Tiago', '1234567', '2021-11-11', 'tiaggga', 'adasda', '123', 1),
(8, 'aaaa', '1234567', '2021-11-11', 'asd', 'Tiago_facu', '123', 4),
(9, 'teste12', '1234567', '2021-11-12', 'teste112', 'teste12', '123', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_ingrediente`
--

CREATE TABLE `g4_ingrediente` (
  `id_Ingrediente` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_ingrediente`
--

INSERT INTO `g4_ingrediente` (`id_Ingrediente`, `nome`, `descricao`) VALUES
(1, 'farinha', 'farinha de trigo'),
(2, 'açúcar ', 'açúcar cristal'),
(5, 'batata', 'batata inglesa'),
(6, 'teste1', 'o teste final');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_livro`
--

CREATE TABLE `g4_livro` (
  `id_Livro` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `isbn` int(13) NOT NULL,
  `editor` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_livro`
--

INSERT INTO `g4_livro` (`id_Livro`, `titulo`, `isbn`, `editor`) VALUES
(0, 'como cozinhar com o micro-ondas ', 12312312, 'abacatess'),
(2, 'o pequeno', 123, 'tiago'),
(3, 'testeaa', 123, 'accc'),
(8, 'o pequeno ', 123, 'teste'),
(10, 'adsdsa', 123, 'fghfgh'),
(12, 'o pequeno ', 123, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_medida`
--

CREATE TABLE `g4_medida` (
  `id_Medida` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_medida`
--

INSERT INTO `g4_medida` (`id_Medida`, `descricao`) VALUES
(1, 'ml'),
(2, 'litro'),
(3, 'colher de sopa'),
(4, 'colher de chá'),
(5, 'xicara '),
(6, 'teste1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_parametro_sistema`
--

CREATE TABLE `g4_parametro_sistema` (
  `mes_producao` smallint(6) NOT NULL,
  `ano_producao` year(4) NOT NULL,
  `qtde_receita` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_publicacao`
--

CREATE TABLE `g4_publicacao` (
  `id_Publicacao` int(11) NOT NULL,
  `id_Livro` int(11) NOT NULL,
  `id_Receita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_receita`
--

CREATE TABLE `g4_receita` (
  `id_Receita` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `data_criacao` date NOT NULL,
  `modo_preparo` varchar(400) NOT NULL,
  `qtde_porcao` decimal(3,1) NOT NULL,
  `id_Categoria` int(11) NOT NULL,
  `id_Funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_receita`
--

INSERT INTO `g4_receita` (`id_Receita`, `nome`, `data_criacao`, `modo_preparo`, `qtde_porcao`, `id_Categoria`, `id_Funcionario`) VALUES
(1, 'pudim', '2021-11-11', 'taca tudo', '1.0', 4, 2),
(4, 'batata quento', '2021-11-11', 'coloca tudo e taca no forno', '1.0', 5, 1),
(7, 'Frango assado', '2021-11-15', 'Asse o frango em fogo médio', '1.0', 3, 1),
(8, 'MACARRÃO COM REQUEIJÃO', '2021-11-16', 'Em uma panela aqueça ...', '2.0', 4, 1),
(9, 'COSTELINHA COM MOLHO BARBECUE (OUTBACK)', '2021-11-16', 'Espalhe sal por toda a c...', '10.0', 3, 1),
(10, 'CUPIM MACIO', '2021-11-17', 'Lave bem a peça de cupim...', '1.0', 3, 1),
(11, 'CHOCOLATE QUENTE ESPECIAL', '2021-11-18', 'Bater todos os in...', '10.0', 1, 1),
(12, 'CAFÉ CREMOSO', '2021-11-17', 'Junte todos os ingredient...', '7.0', 11, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_referencia`
--

CREATE TABLE `g4_referencia` (
  `id_Referencia` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `id_Restaurante` int(11) NOT NULL,
  `id_Funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_referencia`
--

INSERT INTO `g4_referencia` (`id_Referencia`, `data_inicio`, `data_fim`, `id_Restaurante`, `id_Funcionario`) VALUES
(1, '2021-11-11', '2021-11-18', 2, 1),
(2, '2021-11-11', '2021-11-11', 1, 1),
(6, '2021-12-17', '2022-01-01', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `g4_restaurante`
--

CREATE TABLE `g4_restaurante` (
  `id_Restaurante` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `g4_restaurante`
--

INSERT INTO `g4_restaurante` (`id_Restaurante`, `nome`) VALUES
(1, 'coco bambu'),
(2, ' Chicago Prime'),
(3, 'BSB Grill'),
(4, 'Saveur Bistrot'),
(6, 'teste1'),
(9, 'teste2');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `g4_cargo`
--
ALTER TABLE `g4_cargo`
  ADD PRIMARY KEY (`id_Cargo`);

--
-- Índices para tabela `g4_categoria`
--
ALTER TABLE `g4_categoria`
  ADD PRIMARY KEY (`id_Categoria`);

--
-- Índices para tabela `g4_composicao`
--
ALTER TABLE `g4_composicao`
  ADD PRIMARY KEY (`id_Composicao`,`id_Ingrediente`,`id_Medida`,`id_Receita`),
  ADD KEY `fk_G4_Composicao_G4_Ingrediente1_idx` (`id_Ingrediente`),
  ADD KEY `fk_G4_Composicao_G4_Medida1_idx` (`id_Medida`),
  ADD KEY `fk_G4_Composicao_G4_Receita1_idx` (`id_Receita`);

--
-- Índices para tabela `g4_degustacao`
--
ALTER TABLE `g4_degustacao`
  ADD PRIMARY KEY (`id_Degustacao`,`id_Funcionario`,`id_Receita`),
  ADD KEY `fk_G4_Degustacao_G4_Funcionario1_idx` (`id_Funcionario`),
  ADD KEY `fk_G4_Degustacao_G4_Receita1_idx` (`id_Receita`);

--
-- Índices para tabela `g4_funcionario`
--
ALTER TABLE `g4_funcionario`
  ADD PRIMARY KEY (`id_Funcionario`,`id_Cargo`),
  ADD KEY `fk_G4_Funcionario_G4_Cargo1_idx` (`id_Cargo`);

--
-- Índices para tabela `g4_ingrediente`
--
ALTER TABLE `g4_ingrediente`
  ADD PRIMARY KEY (`id_Ingrediente`);

--
-- Índices para tabela `g4_livro`
--
ALTER TABLE `g4_livro`
  ADD PRIMARY KEY (`id_Livro`);

--
-- Índices para tabela `g4_medida`
--
ALTER TABLE `g4_medida`
  ADD PRIMARY KEY (`id_Medida`);

--
-- Índices para tabela `g4_parametro_sistema`
--
ALTER TABLE `g4_parametro_sistema`
  ADD PRIMARY KEY (`mes_producao`,`ano_producao`);

--
-- Índices para tabela `g4_publicacao`
--
ALTER TABLE `g4_publicacao`
  ADD PRIMARY KEY (`id_Publicacao`,`id_Livro`,`id_Receita`),
  ADD KEY `fk_G4_Publicacao_G4_Livro1_idx` (`id_Livro`),
  ADD KEY `fk_G4_Publicacao_G4_Receita1_idx` (`id_Receita`);

--
-- Índices para tabela `g4_receita`
--
ALTER TABLE `g4_receita`
  ADD PRIMARY KEY (`id_Receita`,`id_Categoria`,`id_Funcionario`),
  ADD KEY `fk_G4_Receita_G4_Categoria1_idx` (`id_Categoria`),
  ADD KEY `fk_G4_Receita_G4_Funcionario1_idx` (`id_Funcionario`);

--
-- Índices para tabela `g4_referencia`
--
ALTER TABLE `g4_referencia`
  ADD PRIMARY KEY (`id_Referencia`,`id_Restaurante`,`id_Funcionario`),
  ADD KEY `fk_G4_Referencia_G4_Restaurante1_idx` (`id_Restaurante`),
  ADD KEY `fk_G4_Referencia_G4_Funcionario1_idx` (`id_Funcionario`);

--
-- Índices para tabela `g4_restaurante`
--
ALTER TABLE `g4_restaurante`
  ADD PRIMARY KEY (`id_Restaurante`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `g4_cargo`
--
ALTER TABLE `g4_cargo`
  MODIFY `id_Cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `g4_categoria`
--
ALTER TABLE `g4_categoria`
  MODIFY `id_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `g4_composicao`
--
ALTER TABLE `g4_composicao`
  MODIFY `id_Composicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `g4_degustacao`
--
ALTER TABLE `g4_degustacao`
  MODIFY `id_Degustacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `g4_funcionario`
--
ALTER TABLE `g4_funcionario`
  MODIFY `id_Funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `g4_ingrediente`
--
ALTER TABLE `g4_ingrediente`
  MODIFY `id_Ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `g4_livro`
--
ALTER TABLE `g4_livro`
  MODIFY `id_Livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `g4_medida`
--
ALTER TABLE `g4_medida`
  MODIFY `id_Medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `g4_publicacao`
--
ALTER TABLE `g4_publicacao`
  MODIFY `id_Publicacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `g4_receita`
--
ALTER TABLE `g4_receita`
  MODIFY `id_Receita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `g4_referencia`
--
ALTER TABLE `g4_referencia`
  MODIFY `id_Referencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `g4_restaurante`
--
ALTER TABLE `g4_restaurante`
  MODIFY `id_Restaurante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `g4_composicao`
--
ALTER TABLE `g4_composicao`
  ADD CONSTRAINT `fk_G4_Composicao_G4_Ingrediente1` FOREIGN KEY (`id_Ingrediente`) REFERENCES `g4_ingrediente` (`id_Ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Composicao_G4_Medida1` FOREIGN KEY (`id_Medida`) REFERENCES `g4_medida` (`id_Medida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Composicao_G4_Receita1` FOREIGN KEY (`id_Receita`) REFERENCES `g4_receita` (`id_Receita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `g4_degustacao`
--
ALTER TABLE `g4_degustacao`
  ADD CONSTRAINT `fk_G4_Degustacao_G4_Funcionario1` FOREIGN KEY (`id_Funcionario`) REFERENCES `g4_funcionario` (`id_Funcionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Degustacao_G4_Receita1` FOREIGN KEY (`id_Receita`) REFERENCES `g4_receita` (`id_Receita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `g4_funcionario`
--
ALTER TABLE `g4_funcionario`
  ADD CONSTRAINT `fk_G4_Funcionario_G4_Cargo1` FOREIGN KEY (`id_Cargo`) REFERENCES `g4_cargo` (`id_Cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `g4_publicacao`
--
ALTER TABLE `g4_publicacao`
  ADD CONSTRAINT `fk_G4_Publicacao_G4_Livro1` FOREIGN KEY (`id_Livro`) REFERENCES `g4_livro` (`id_Livro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Publicacao_G4_Receita1` FOREIGN KEY (`id_Receita`) REFERENCES `g4_receita` (`id_Receita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `g4_receita`
--
ALTER TABLE `g4_receita`
  ADD CONSTRAINT `fk_G4_Receita_G4_Categoria1` FOREIGN KEY (`id_Categoria`) REFERENCES `g4_categoria` (`id_Categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Receita_G4_Funcionario1` FOREIGN KEY (`id_Funcionario`) REFERENCES `g4_funcionario` (`id_Funcionario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `g4_referencia`
--
ALTER TABLE `g4_referencia`
  ADD CONSTRAINT `fk_G4_Referencia_G4_Funcionario1` FOREIGN KEY (`id_Funcionario`) REFERENCES `g4_funcionario` (`id_Funcionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_G4_Referencia_G4_Restaurante1` FOREIGN KEY (`id_Restaurante`) REFERENCES `g4_restaurante` (`id_Restaurante`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
