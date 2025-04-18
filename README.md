# NotaFiscal-Loterica

Linguagens utilizadas: PHP, MySql, HTML/CSS

## Proposta

A proposta é fazer um programa que pudesse contabilizar compras, somar pontos e sortear um vencedor, como uma lotérica. É possível logar como Estabelecimento(lotérica), User ou ADM. A quantidade de pontos(1R$ = 1 ponto) acumulada por cada usuário será revertida em sua probabilidade de vencer o sorteio. Alguns dados estão pré inseridos pra facilitar testes e a funcionalidade do programa.

## Dados Pre-Inseridos no Bando de Dados

--> INSERT INTO ADM (CPF, Nome, Email, Celular, Senha) VALUES
('15161444657', 'Felipe Mendes', 'felipe.davila.bh@gmail.com', '31971740540', 'robin'),
('14578455856', 'Maria Eduarda', 'duda@gmail.com', '31975489526', '123');

--> INSERT INTO Estabelecimento (Nome, Local, CNPJ) VALUES
('CAIXA', 'BH', '12.345.678/0001-90'),
('Loterica Green', 'SP', '98.765.432/0001-01');

--> INSERT INTO User (Nome, Email, Celular, Senha, CPF, Pontos) VALUES ('Marcio Fantini', 'mf@gmail.com', '31999555724', '123', 'cpf', 0);

## LINK de acesso

-- http://150.164.102.160/turma2024-integrado/303/a2023951571@teiacoltec.org/hp/NotaFiscal/index.php

## Autor

-- Felipe Davila Mendes, https://github.com/lippe13
