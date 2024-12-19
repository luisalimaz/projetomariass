-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Dez-2024 às 01:40
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdacademia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `fkidusuario` int(11) NOT NULL,
  `fkidtreino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrutor`
--

CREATE TABLE `instrutor` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `fone` varchar(15) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `datanas` date NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `instrutor`
--

INSERT INTO `instrutor` (`id`, `nome`, `cpf`, `email`, `senha`, `fone`, `sexo`, `area`, `datanas`, `imagem`) VALUES
(3, 'leon', 57635, 'leon@gmail.com', '$2y$10$rKxi0KnsCevlmy05hufh/OZbE6f7cUOC/S3vKkRTROptcOp5Vlqiy', '51992608140', 'M', 'P', '1985-12-10', 'img/laurenf00710183802.png'),
(4, 'Fabia', 879854, 'fab@gmail.com', '$2y$10$Rc0h/dM6F1/AAH9L1EI8v.ssaBq4hb.0Xh0tZz/RVshxUP7WfF8Yu', '51992608140', 'F', 'F', '2000-02-19', 'img/Liv.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `treino`
--

CREATE TABLE `treino` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `exercicio` varchar(255) NOT NULL,
  `fkidinstrutor` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `treino`
--

INSERT INTO `treino` (`id`, `tipo`, `exercicio`, `fkidinstrutor`, `descricao`) VALUES
(3, 'emagrecer', 'Natação. A natação é um esporte completo que traz muitos benefícios para a nossa saúde. ... Corrida. ... Ciclismo. ... Musculação. ... Crossfit. ... Treinamento funcional. ... Hidroginástica.', 4, 'para emagrecer'),
(9, 'fisio', 'Exercícios de amplitude de movimento. ... Exercícios de fortalecimento muscular. ... Exercícios de coordenação e equilíbrio. ... Exercícios de ambulação. ... Exercícios de condicionamento geral. ... Treinamento de transferência. ... Mesa inclinada.', 3, 'Exercícios de amplitude de movimento. ... Exercícios de fortalecimento muscular. ... Exercícios de coordenação e equilíbrio. ... Exercícios de ambulação. ... Exercícios de condicionamento geral. ... Treinamento de transferência. ... Mesa inclinada.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `fone` varchar(15) NOT NULL,
  `sexo` varchar(15) NOT NULL,
  `cpf` int(11) NOT NULL,
  `dataN` date NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `altura` decimal(4,2) NOT NULL,
  `codigo_verificacao` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `fone`, `sexo`, `cpf`, `dataN`, `peso`, `altura`, `codigo_verificacao`) VALUES
(2, 'maria', 'marialuisarodrigues602@gmail.com', '$2y$10$MOZ7dv8lbI7FG/BpFpi63eLbCypKJJrVd4oxYAerPf5SUNhfMaHQO', '51992608140', 'F', 879854, '2000-02-20', 74.00, 99.99, NULL),
(3, 'Eduarda', 'eduarda04santos18@gmail.com', '$2y$10$aMVrxln3cZS.0eVmf7eZvedxnnv7DUthPKnoj.O3ILDNMA79nYljO', '51992608190', 'F', 57635, '2000-04-18', 70.00, 99.99, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidusuario` (`fkidusuario`),
  ADD KEY `fkidtreino` (`fkidtreino`);

--
-- Índices para tabela `instrutor`
--
ALTER TABLE `instrutor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `treino`
--
ALTER TABLE `treino`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidinstrutor` (`fkidinstrutor`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `instrutor`
--
ALTER TABLE `instrutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `treino`
--
ALTER TABLE `treino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`fkidusuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `agendamento_ibfk_2` FOREIGN KEY (`fkidtreino`) REFERENCES `treino` (`id`);

--
-- Limitadores para a tabela `treino`
--
ALTER TABLE `treino`
  ADD CONSTRAINT `treino_ibfk_1` FOREIGN KEY (`fkidinstrutor`) REFERENCES `instrutor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
