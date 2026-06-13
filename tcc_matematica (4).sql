-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/06/2026 às 02:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc_matematica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alternativas`
--

CREATE TABLE `alternativas` (
  `id` int(11) NOT NULL,
  `questao_id` int(11) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `correta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alternativas`
--

INSERT INTO `alternativas` (`id`, `questao_id`, `texto`, `correta`) VALUES
(48, 1, 'Quadrado', 1),
(49, 1, 'Triângulo', 0),
(50, 1, 'Círculo', 0),
(51, 1, 'Retângulo', 0),
(52, 2, 'Triângulo', 1),
(53, 2, 'Quadrado', 0),
(54, 2, 'Círculo', 0),
(55, 2, 'Retângulo', 0),
(56, 3, 'Retângulo', 1),
(57, 3, 'Triângulo', 0),
(58, 3, 'Círculo', 0),
(59, 3, 'Pentágono', 0),
(60, 4, 'Cubo', 1),
(61, 4, 'Esfera', 0),
(62, 4, 'Cone', 0),
(63, 4, 'Cilindro', 0),
(64, 5, 'Círculo', 1),
(65, 5, 'Quadrado', 0),
(66, 5, 'Triângulo', 0),
(67, 5, 'Retângulo', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `conquistas`
--

CREATE TABLE `conquistas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `icone` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `conquistas`
--

INSERT INTO `conquistas` (`id`, `nome`, `descricao`, `icone`, `tipo`, `valor`) VALUES
(1, 'Primeiro Passo', 'Acerte sua primeira questão', 'primeiro_passo.png', 'acerto', 1),
(2, 'Aquecendo', 'Acerte 5 questões', 'aquecendo.png', 'acerto', 5),
(3, 'Curioso', 'Acerte em 2 temas diferentes', 'curioso.png', 'tema_variedade', 2),
(4, 'Pegando o Ritmo', 'Acerte 10 questões', 'pegando_o_ritmo.png', 'acerto', 10),
(5, 'Boa Fase', 'Acerte 25 questões', 'boa_fase.png', 'acerto', 25),
(6, 'Confiante', 'Acerte 50 questões', 'confiante.png', 'acerto', 50),
(7, 'Afiação Mental', 'Acerte 80 questões', 'afiacao_mental.png', 'acerto', 80),
(8, 'Cirúrgico', 'Acerte 120 questões', 'cirurgico.png', 'acerto', 120),
(9, 'Impecável', 'Acerte 200 questões', 'impecavel.png', 'acerto', 200),
(10, 'Sequência Inicial', '5 acertos seguidos', 'sequencia_inicial.png', 'streak', 5),
(11, 'Foco Total', '15 acertos seguidos', 'foco_total.png', 'streak', 15),
(12, 'Modo Turbo', '30 acertos seguidos', 'modo_turbo.png', 'streak', 30),
(13, 'Inabalável', '50 acertos seguidos', 'inabalavel.png', 'streak', 50),
(14, 'Máquina', '70 acertos seguidos', 'maquina.png', 'streak', 70),
(15, 'Imparável', '100 acertos seguidos', 'imparavel.png', 'streak', 100),
(16, 'Primeira Vitória', 'Complete 1 prova', 'primeira_vitoria.png', 'prova', 1),
(17, 'Persistência', 'Complete 5 provas', 'persistencia.png', 'prova', 5),
(18, 'Regular', 'Complete 10 provas', 'regular.png', 'prova', 10),
(19, 'Veterano das Provas', 'Complete 20 provas', 'veterano_das_provas.png', 'prova', 20),
(20, 'Incansável', 'Complete 35 provas', 'incansavel.png', 'prova', 35),
(21, 'Maratonista', 'Complete 60 provas', 'maratonista.png', 'prova', 60),
(22, 'Iniciante', 'Alcance nível 2', 'iniciante.png', 'nivel', 2),
(23, 'Avançado', 'Alcance nível 4', 'avancado.png', 'nivel', 4),
(24, 'Experiente', 'Alcance nível 6', 'experiente.png', 'nivel', 6),
(25, 'Veterano', 'Alcance nível 8', 'veterano.png', 'nivel', 8),
(26, 'Elite', 'Alcance nível 10', 'elite.png', 'nivel', 10),
(27, 'Mestre', 'Alcance nível máximo', 'mestre.png', 'nivel', 15),
(28, 'Geômetra', 'Acerte 20 questões de geometria', 'geometra.png', 'tema_geometria', 20),
(29, 'Potência Pura', 'Acerte 20 de potenciação', 'potencia_pura.png', 'tema_potencia', 20),
(30, 'Funções na Veia', 'Acerte 20 de funções', 'funcoes_na_veia.png', 'tema_funcoes', 20),
(31, 'Equacionador', 'Acerte 20 de equações', 'equacionador.png', 'tema_equacoes', 20),
(32, 'Polímata', 'Acerte em 4 temas diferentes', 'polimata.png', 'tema_variedade', 4),
(33, 'Primeiro Erro', 'Erre uma questão', 'primeiro_erro.png', 'erro', 1),
(34, 'Aprendendo', 'Erre 8 vezes', 'aprendendo.png', 'erro', 8),
(35, 'Não Desistiu', 'Erre 20 vezes', 'nao_desistiu.png', 'erro', 20),
(36, 'Teimoso', 'Erre 40 vezes', 'teimoso.png', 'erro', 40),
(37, 'Equilíbrio', 'Acerte e erre na mesma prova', 'equilibrio.png', 'especial', 1),
(38, 'Explorador', 'Jogue nos 3 níveis', 'explorador.png', 'especial', 3),
(39, 'Corajoso', 'Complete no difícil', 'corajoso.png', 'dificil', 1),
(40, 'Perfeccionista', 'Faça 3 provas perfeitas', 'perfeccionista.png', 'perfeito', 3),
(41, 'Viciado', 'Complete 100 questões', 'viciado.png', 'especial', 100),
(42, 'Mito', 'Complete tudo', 'mito.png', 'especial', 999);

-- --------------------------------------------------------

--
-- Estrutura para tabela `progresso`
--

CREATE TABLE `progresso` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_questao` int(11) NOT NULL,
  `acertou` tinyint(1) NOT NULL,
  `tentativas` int(11) DEFAULT 1,
  `xp_ganho` int(11) NOT NULL,
  `nivel` enum('facil','medio','dificil') NOT NULL,
  `data_hora` datetime DEFAULT current_timestamp(),
  `id_prova` int(11) DEFAULT NULL,
  `tema` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

CREATE TABLE `questoes` (
  `id` int(11) NOT NULL,
  `tema` varchar(50) DEFAULT NULL,
  `nivel` varchar(20) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `enunciado` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`id`, `tema`, `nivel`, `tipo`, `enunciado`, `imagem`, `data_criacao`) VALUES
(1, 'geometria', 'facil', 'multipla', 'Qual figura tem 4 lados iguais?', 'quadrado.png', '2026-03-14 01:57:45'),
(2, 'geometria', 'facil', 'multipla', 'Qual figura tem 3 lados?', 'triangulo.png', '2026-03-14 01:57:45'),
(3, 'geometria', 'facil', 'multipla', 'Qual figura tem lados opostos iguais?', 'retangulo.png', '2026-03-14 01:57:46'),
(4, 'geometria', 'facil', 'multipla', 'Qual sólido tem 6 faces quadradas?', 'cubo.png', '2026-03-14 01:57:46'),
(5, 'geometria', 'facil', 'multipla', 'Qual figura é redonda?', 'circulo.png', '2026-03-14 01:57:46'),
(6, 'potenciacao', 'facil', 'aberta', 'Quanto é 2³ ?', NULL, '2026-03-14 01:57:47'),
(7, 'potenciacao', 'facil', 'aberta', 'Quanto é 3² ?', NULL, '2026-03-14 01:57:47'),
(8, 'potenciacao', 'facil', 'aberta', 'Quanto é 5² ?', NULL, '2026-03-14 01:57:48'),
(9, 'potenciacao', 'facil', 'aberta', 'Quanto é 10² ?', NULL, '2026-03-14 01:57:48'),
(10, 'potenciacao', 'facil', 'aberta', 'Quanto é 4² ?', NULL, '2026-03-14 01:57:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_abertas`
--

CREATE TABLE `respostas_abertas` (
  `id` int(11) NOT NULL,
  `questao_id` int(11) DEFAULT NULL,
  `resposta` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_abertas`
--

INSERT INTO `respostas_abertas` (`id`, `questao_id`, `resposta`) VALUES
(1, 6, '8'),
(2, 7, '9'),
(3, 8, '25'),
(4, 9, '100'),
(5, 10, '16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tema` varchar(50) DEFAULT NULL,
  `nivel` varchar(20) DEFAULT NULL,
  `pontuacao` int(11) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('aluno','admin') DEFAULT 'aluno',
  `xp_total` int(11) DEFAULT 0,
  `nivel` int(11) DEFAULT 1,
  `xp_proximo_nivel` int(11) DEFAULT 10,
  `objetivos` text DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_conquistas`
--

CREATE TABLE `usuario_conquistas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `conquista_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_conquistas`
--

INSERT INTO `usuario_conquistas` (`id`, `usuario_id`, `conquista_id`) VALUES
(5, 4, 1),
(6, 4, 2),
(7, 4, 10),
(8, 4, 33),
(9, 4, 37),
(10, 4, 4),
(11, 5, 1),
(12, 5, 2),
(13, 5, 10),
(14, 5, 4),
(15, 5, 40),
(16, 6, 1),
(17, 6, 16),
(18, 6, 2),
(19, 6, 10);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alternativas`
--
ALTER TABLE `alternativas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questao_id` (`questao_id`);

--
-- Índices de tabela `conquistas`
--
ALTER TABLE `conquistas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `progresso`
--
ALTER TABLE `progresso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_questao` (`id_questao`);

--
-- Índices de tabela `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `respostas_abertas`
--
ALTER TABLE `respostas_abertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questao_id` (`questao_id`);

--
-- Índices de tabela `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuario_conquistas`
--
ALTER TABLE `usuario_conquistas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alternativas`
--
ALTER TABLE `alternativas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `conquistas`
--
ALTER TABLE `conquistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `progresso`
--
ALTER TABLE `progresso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `respostas_abertas`
--
ALTER TABLE `respostas_abertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuario_conquistas`
--
ALTER TABLE `usuario_conquistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alternativas`
--
ALTER TABLE `alternativas`
  ADD CONSTRAINT `alternativas_ibfk_1` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`);

--
-- Restrições para tabelas `progresso`
--
ALTER TABLE `progresso`
  ADD CONSTRAINT `progresso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `progresso_ibfk_2` FOREIGN KEY (`id_questao`) REFERENCES `questoes` (`id`);

--
-- Restrições para tabelas `respostas_abertas`
--
ALTER TABLE `respostas_abertas`
  ADD CONSTRAINT `respostas_abertas_ibfk_1` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
