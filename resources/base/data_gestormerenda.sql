-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database:3306
-- Tempo de geração: 24/05/2023 às 14:05
-- Versão do servidor: 8.0.33
-- Versão do PHP: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `data_gestormerenda`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_calendario`
--

CREATE TABLE `tabgm_calendario` (
  `id` int NOT NULL,
  `secretaria` int NOT NULL,
  `ano` int NOT NULL,
  `data` date NOT NULL,
  `observacao` text COLLATE utf8mb3_unicode_ci,
  `tipo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_company`
--

CREATE TABLE `tabgm_company` (
  `id` int NOT NULL,
  `sistema` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `company` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `cnpj` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `endereco` text COLLATE utf8mb3_unicode_ci,
  `telefone` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb3_unicode_ci,
  `logo` text COLLATE utf8mb3_unicode_ci,
  `urlbase` text COLLATE utf8mb3_unicode_ci,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_departamentos`
--

CREATE TABLE `tabgm_departamentos` (
  `id` int NOT NULL,
  `tipo` int NOT NULL,
  `departamento` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `inep` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `secretaria` int NOT NULL,
  `alunado` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `endereco` int DEFAULT NULL,
  `telefone` text COLLATE utf8mb3_unicode_ci,
  `email` text COLLATE utf8mb3_unicode_ci,
  `dtcreate` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_entradas`
--

CREATE TABLE `tabgm_entradas` (
  `id` int NOT NULL,
  `origem` int DEFAULT NULL,
  `secretaria` int NOT NULL,
  `departamento` int DEFAULT NULL,
  `insumos` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL,
  `dtreceiver` datetime DEFAULT NULL,
  `agentereceiver` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_estoques`
--

CREATE TABLE `tabgm_estoques` (
  `id` int NOT NULL,
  `insumo` int NOT NULL,
  `secretaria` int NOT NULL,
  `departamento` int DEFAULT NULL,
  `quantidade` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_historys`
--

CREATE TABLE `tabgm_historys` (
  `id` int NOT NULL,
  `tipo` int NOT NULL,
  `origem` int NOT NULL,
  `observacao` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_insumos`
--

CREATE TABLE `tabgm_insumos` (
  `id` int NOT NULL,
  `insumo` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `percapitas` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `tipo` int NOT NULL,
  `unidade` int NOT NULL,
  `medida` int NOT NULL,
  `volume` float NOT NULL,
  `qtalerta` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_producao`
--

CREATE TABLE `tabgm_producao` (
  `id` int NOT NULL,
  `data` date NOT NULL,
  `secretaria` int NOT NULL,
  `departamento` int NOT NULL,
  `producao` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `saida` int NOT NULL,
  `observacao` text COLLATE utf8mb3_unicode_ci,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_saidas`
--

CREATE TABLE `tabgm_saidas` (
  `id` int NOT NULL,
  `origem` int DEFAULT NULL,
  `secretaria` int NOT NULL,
  `departamento` int DEFAULT NULL,
  `insumos` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_secretarias`
--

CREATE TABLE `tabgm_secretarias` (
  `id` int NOT NULL,
  `secretaria` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `cnpj` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `endereco` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefone` varchar(30) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb3_unicode_ci,
  `dtcreate` datetime DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabgm_usuarios`
--

CREATE TABLE `tabgm_usuarios` (
  `id` int NOT NULL,
  `nome` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cpf` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefone` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `uid` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `pid` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `perfil` int NOT NULL,
  `nivel` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `secretaria` int DEFAULT NULL,
  `departamentos` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` int NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `nowlogin` datetime DEFAULT NULL,
  `passchange` int NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtupdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `agente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `tabgm_usuarios`
--

INSERT INTO `tabgm_usuarios` (`id`, `nome`, `cpf`, `email`, `telefone`, `uid`, `pid`, `perfil`, `nivel`, `secretaria`, `departamentos`, `status`, `lastlogin`, `nowlogin`, `passchange`, `dtcreate`, `dtupdate`, `agente`) VALUES
(1, 'OCTUS PI', '045.738.823-40', 'octuspi@gmail.com', '(88)9.9324-3731', '1784263bb2b844382e6bbf8e1bf2d400', '1784263bb2b844382e6bbf8e1bf2d400', 1, '0,1,2,3,4,5,6,7,8,9', NULL, NULL, 1, '2023-05-23 18:22:16', '2023-05-23 18:52:46', 0, '2023-05-23 19:31:32', '2023-05-23 19:32:22', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tabgm_calendario`
--
ALTER TABLE `tabgm_calendario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calendario_fk_secretaria` (`secretaria`);

--
-- Índices de tabela `tabgm_company`
--
ALTER TABLE `tabgm_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_departamentos`
--
ALTER TABLE `tabgm_departamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamentos_fk_secretaria` (`secretaria`),
  ADD KEY `departamentos_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_entradas`
--
ALTER TABLE `tabgm_entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entradas_fk_secretaria` (`secretaria`),
  ADD KEY `entradas_fk_departamento` (`departamento`),
  ADD KEY `entradas_fk_agente` (`agente`),
  ADD KEY `entradas_fk_agenterec` (`agentereceiver`);

--
-- Índices de tabela `tabgm_estoques`
--
ALTER TABLE `tabgm_estoques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estoques_fk_insumo` (`insumo`),
  ADD KEY `estoques_fk_secretaria` (`secretaria`),
  ADD KEY `estoques_fk_departamento` (`departamento`),
  ADD KEY `estoques_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_historys`
--
ALTER TABLE `tabgm_historys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historys_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_insumos`
--
ALTER TABLE `tabgm_insumos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insumos_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_producao`
--
ALTER TABLE `tabgm_producao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producao_fk_agente` (`agente`),
  ADD KEY `producao_fk_secretaria` (`secretaria`),
  ADD KEY `producao_fk_departamento` (`departamento`);

--
-- Índices de tabela `tabgm_saidas`
--
ALTER TABLE `tabgm_saidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saidas_fk_agente` (`agente`),
  ADD KEY `saidas_fk_secretarias` (`secretaria`),
  ADD KEY `saidas_fk_departamentos` (`departamento`);

--
-- Índices de tabela `tabgm_secretarias`
--
ALTER TABLE `tabgm_secretarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `secretarias_fk_agente` (`agente`);

--
-- Índices de tabela `tabgm_usuarios`
--
ALTER TABLE `tabgm_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tabgm_calendario`
--
ALTER TABLE `tabgm_calendario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_company`
--
ALTER TABLE `tabgm_company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_departamentos`
--
ALTER TABLE `tabgm_departamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_entradas`
--
ALTER TABLE `tabgm_entradas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_estoques`
--
ALTER TABLE `tabgm_estoques`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_historys`
--
ALTER TABLE `tabgm_historys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_insumos`
--
ALTER TABLE `tabgm_insumos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_producao`
--
ALTER TABLE `tabgm_producao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_saidas`
--
ALTER TABLE `tabgm_saidas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_secretarias`
--
ALTER TABLE `tabgm_secretarias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabgm_usuarios`
--
ALTER TABLE `tabgm_usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tabgm_calendario`
--
ALTER TABLE `tabgm_calendario`
  ADD CONSTRAINT `calendario_fk_secretaria` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_company`
--
ALTER TABLE `tabgm_company`
  ADD CONSTRAINT `company_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_departamentos`
--
ALTER TABLE `tabgm_departamentos`
  ADD CONSTRAINT `departamentos_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `departamentos_fk_secretaria` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_entradas`
--
ALTER TABLE `tabgm_entradas`
  ADD CONSTRAINT `entradas_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entradas_fk_agenterec` FOREIGN KEY (`agentereceiver`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entradas_fk_departamento` FOREIGN KEY (`departamento`) REFERENCES `tabgm_departamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entradas_fk_secretaria` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_estoques`
--
ALTER TABLE `tabgm_estoques`
  ADD CONSTRAINT `estoques_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `estoques_fk_departamento` FOREIGN KEY (`departamento`) REFERENCES `tabgm_departamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `estoques_fk_insumo` FOREIGN KEY (`insumo`) REFERENCES `tabgm_insumos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `estoques_fk_secretaria` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_historys`
--
ALTER TABLE `tabgm_historys`
  ADD CONSTRAINT `historys_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_insumos`
--
ALTER TABLE `tabgm_insumos`
  ADD CONSTRAINT `insumos_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_producao`
--
ALTER TABLE `tabgm_producao`
  ADD CONSTRAINT `producao_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `producao_fk_departamento` FOREIGN KEY (`departamento`) REFERENCES `tabgm_departamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `producao_fk_secretaria` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_saidas`
--
ALTER TABLE `tabgm_saidas`
  ADD CONSTRAINT `saidas_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `saidas_fk_departamentos` FOREIGN KEY (`departamento`) REFERENCES `tabgm_departamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `saidas_fk_secretarias` FOREIGN KEY (`secretaria`) REFERENCES `tabgm_secretarias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tabgm_secretarias`
--
ALTER TABLE `tabgm_secretarias`
  ADD CONSTRAINT `secretarias_fk_agente` FOREIGN KEY (`agente`) REFERENCES `tabgm_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
