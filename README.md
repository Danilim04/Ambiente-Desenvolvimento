
# Ambiente de Desenvolvimento Dockerizado  

## Descrição
Este projeto configura um ambiente de desenvolvimento completo utilizando Docker Compose, facilitando o processo de desenvolvimento para equipes. Ele inclui Nginx como servidor web, uma aplicação com Dockerfile personalizado para atender requisitos específicos de dependências, e Redis como armazenamento de dados em memória.

## Estrutura do Ambiente
- **Nginx**: Atua como servidor web e proxy reverso.
- **Aplicação**: Contém um Dockerfile personalizado configurado com as dependências necessárias para o projeto.
- **Redis**: Utilizado para caching e armazenamento de dados em memória, melhorando a performance da aplicação.

## Objetivos
- **Padronização do Ambiente**: Garantir que todos os desenvolvedores trabalhem em um ambiente consistente e controlado.
- **Facilidade de Setup**: Simplificar o processo de configuração do ambiente de desenvolvimento para novos desenvolvedores.
- **Desenvolvimento Ágil**: Permitir que a equipe de desenvolvimento se concentre mais na codificação e menos na configuração de ambientes.

## Tecnologias Utilizadas
- **Docker**: Para criar e gerenciar containers.
- **Docker Compose**: Para definir e rodar múltiplos containers de serviço.
- **Nginx**: Como servidor web e proxy reverso.
- **Redis**: Como banco de dados em memória para caching e sessões rápidas.

## Como Usar

## Passo 1: Clone o Repositório
Baixe o repositório para a sua máquina utilizando o comando:
```bash
git clone <URL do Repositório>
```

## Passo 2: Inicialize os Containers
No diretório do projeto, execute o seguinte comando para construir e iniciar os containers em segundo plano:
```bash
docker-compose up -d --build
```

## Passo 3: Acesse o Container da Aplicação
Após os containers estarem em execução, acesse o container da aplicação com o comando:
```bash
docker-compose exec app bash
```

Dentro do container da aplicação, execute o comando para baixar as dependências do Composer:
```bash
composer install
```
