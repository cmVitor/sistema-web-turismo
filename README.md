# 🗺️ Projeto Final – Sistema Web de Turismo

**Disciplina:** Software para Persistência de Dados  
**Professor:** Elias Ferreira  

----------
## 👥 Integrantes da Equipe
-   👨‍💻 [Samuel Jose Evangelista Alves] - [202201712]
-   👨‍💻 [Vitor Martins Castanheira] - [202201717]
-   👨‍💻 [Guilherme Gonçalves Dutra de Mendonça] - [202201692]
---

## 📌 Visão Geral

Este projeto consiste no desenvolvimento de um **sistema web para cadastro, consulta e avaliação de pontos turísticos**, permitindo que usuários interajam com avaliações, comentários, fotos e hospedagens associadas.

A aplicação foi construída seguindo os requisitos do documento oficial da disciplina, adaptando as tecnologias sugeridas para as stacks escolhidas pelo grupo.

----------

## 🧑‍💻 Stacks Utilizadas

### 🟦 Backend – Laravel (PHP)

Optamos por utilizar o **framework Laravel**, que substitui o conjunto sugerido no documento (Spring Boot, JPA, Hibernate, Tomcat).

Laravel atende a todos os requisitos de:

-   Persistência com banco relacional (Eloquent ORM)
    
-   Integração com NoSQL (MongoDB via driver)
    
-   Autenticação (JWT)
    
-   Cache (Redis)
    
-   Upload de arquivos
    
-   APIs RESTful
    

| Tecnologias Sugeridas     | Equivalente Utilizado               |
|---------------------------|--------------------------------------|
| Java + Spring Boot        | **Laravel**                          |
| Spring Web                | **Laravel Routing / Controllers**    |
| JPA / Hibernate           | **Eloquent ORM**                     |
| Spring Security           | **Laravel JWT / Sanctum**            |
| Spring Data MongoDB       | **Laravel MongoDB Driver (Jenssegers)** |
| Tomcat                    | **Servidor embutido do Laravel**     |


----------

### 🟩 Frontend – Vue.js 3

Usado para construir a interface SPA (Single Page Application).  
Equivale às tecnologias front sugeridas como “livres” no documento.

Utilizamos:

-   **Vue Router** – navegação
    
-   **Pinia** – gerenciamento de estado
    
-   **Axios** – comunicação com o backend
    

----------

### 🟥 Banco de Dados

O documento exige **Relacional + NoSQL + Cache**, e todos foram atendidos:


| Tipo        | Tecnologia Usada      | Papel                                                                 |
|-------------|-----------------------|-----------------------------------------------------------------------|
| Relacional  | **PostgreSQL**        | Usuários, pontos turísticos, hospedagens, avaliações, favoritos       |
| NoSQL       | **MongoDB**           | Comentários e metadados das fotos                                     |
| Cache       | **Redis**             | Cache dos pontos turísticos mais acessados                            |

----------

### 🟫 Armazenamento de Arquivos

-   **Filesystem local** para fotos (como especificado no documento)
    
-   Metadados das fotos ficam no MongoDB
    
---

## 🔧 Funcionalidades Implementadas

-   Registro e login de usuário (JWT)
    
-   CRUD de pontos turísticos
    
-   Upload/listagem de fotos (limite de 10 por ponto)
    
-   Hospedagens relacionadas ao ponto turístico
    
-   Avaliações (1–5 estrelas) e média automática
    
-   Comentários ordenados por data (MongoDB)
    
-   Favoritar pontos
    
-   Busca com filtros
    
-   Endpoint “como chegar” (com latitude/longitude)
    
-   Exportação/importação de pontos turísticos em JSON/XML
    
-   Cache de pontos turísticos mais acessados (Redis)
   
    

----------

## ▶️ Como Executar o Projeto

colocar docker futuramente