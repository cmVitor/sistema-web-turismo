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
    
-   Cache de pontos turísticos mais acessados (Redis)
   
----------

## 🗄️ Persistência de Dados com PostgreSQL

## 📌 Visão Geral

O banco de dados **PostgreSQL** é utilizado como **banco de dados relacional principal** da aplicação, sendo responsável pela **persistência permanente dos dados**.  
Ele armazena informações estruturadas e relacionadas, garantindo **integridade referencial**, **consistência** e **confiabilidade** dos dados.

A aplicação utiliza o **Eloquent ORM (Laravel)** em conjunto com **migrations**, permitindo versionamento do schema e fácil manutenção da estrutura do banco.

----------

## 🧱 Estrutura do Banco de Dados

A modelagem relacional foi implementada por meio de **migrations**, que descrevem de forma explícita a estrutura das tabelas, chaves primárias e relacionamentos.

### 🔹 Principais Entidades Persistidas

-   **Usuários**
    
-   **Pontos Turísticos**
    
-   **Avaliações**
    
-   **Hospedagens**
    
-   **Favoritos**
    

Essas entidades representam os dados essenciais do domínio da aplicação e possuem relacionamentos bem definidos.

----------

## 🛠️ Migrations

As migrations são responsáveis por criar e versionar as tabelas no banco PostgreSQL, permitindo:

-   Controle de versão do schema
    
-   Facilidade de evolução do banco
    
-   Reprodutibilidade do ambiente
    
-   Evitar inconsistências estruturais
    

### 🔹 Exemplo de Migration (Pontos Turísticos)
````
Schema::create('pontos_turisticos', function (Blueprint  $table) {

$table->id();

$table->string('nome');
$table->text('descricao')->nullable();
$table->string('cidade');
$table->string('estado');
$table->string('pais');

$table->decimal('latitude', 10, 7)->nullable();
$table->decimal('longitude', 10, 7)->nullable();

$table->string('endereco')->nullable();

$table->foreignId('criado_por')->constrained('users')->restrictOnDelete();

$table->decimal('nota_media', 3, 2)->default(0);

$table->timestamps();

});
````
----------

## 🧠 Models e ORM (Eloquent)

Cada tabela do banco possui um **Model Eloquent**, responsável por representar e manipular os dados no código de forma orientada a objetos.

### 🔹 Exemplo de Model
````
class  PontoTuristico  extends  Model
{
use  HasFactory;

protected  $table = 'pontos_turisticos';

protected  $fillable = [
'nome',
'descricao',
'cidade',
'estado',
'pais',
'latitude',
'longitude',
'endereco',
'criado_por',
'nota_media',
];

protected  $casts = [
'latitude' => 'float',
'longitude' => 'float',
'nota_media' => 'float',
];

public  function  criador()
{
return  $this->belongsTo(User::class, 'criado_por');
}

public  function  hospedagens()
{
return  $this->hasMany(Hospedagem::class, 'ponto_id');
}

public  function  avaliacoes()
{
return  $this->hasMany(Avaliacao::class, 'ponto_id');
}
}
}` 
````
### ✅ Benefícios do uso de Models

-   Abstração das consultas SQL
    
-   Facilita leitura e manutenção do código
    
-   Integração natural com relacionamentos
    
-   Redução de código repetitivo
    

----------

## 🔗 Relacionamentos entre Entidades

A aplicação utiliza relacionamentos do tipo:

-   **Um-para-muitos**
    
    -   Usuário → Pontos Turísticos
        
    -   Ponto Turístico → Avaliações
        
    -   Ponto Turístico → Hospedagens
        
-   **Muitos-para-muitos**
    
    -   Usuário ↔ Pontos Turísticos (Favoritos)
        

Esses relacionamentos garantem integridade dos dados e refletem corretamente as regras do domínio.

----------

## ✅ Conclusão

O uso do PostgreSQL aliado às **migrations** e **models Eloquent** proporciona uma camada sólida de persistência de dados, garantindo:

-   Estrutura consistente
    
-   Facilidade de manutenção
    
-   Escalabilidade do banco
    
-   Clareza na modelagem relacional
    

Essa abordagem segue boas práticas de desenvolvimento de software orientado à persistência de dados, atendendo aos requisitos da disciplina.

----------
# 🚀 Uso do Redis na Aplicação

## 📌 Visão Geral

Nesta aplicação, o **Redis** é utilizado como um **banco de dados em memória (in-memory)** com foco em **performance, cache e contadores de acesso**.  
Ele atua como um **complemento ao banco relacional**, ajudando a reduzir consultas repetidas ao banco e permitindo métricas rápidas de acesso.

O Redis foi integrado ao backend desenvolvido em **Laravel**, utilizando os recursos nativos de **Cache** e **Redis Facade** do framework.

----------

## 🎯 Objetivos do uso do Redis

O Redis foi implementado com as seguintes finalidades:

-   ✅ **Cachear dados de pontos turísticos acessados com frequência**
    
-   ✅ **Contabilizar acessos aos pontos turísticos**
    
-   ✅ **Reduzir carga no banco de dados relacional**
    
-   ✅ **Aumentar a velocidade de resposta da API**
    
-   ✅ **Servir como base para funcionalidades analíticas**, como a página _“Pontos mais acessados”_
    

----------

## 🧱 Como o Redis foi integrado

### 🔹 Configuração

O Redis é configurado como store padrão de cache no arquivo `.env`:
````
`CACHE_STORE=redis
SESSION_DRIVER=redis

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379` 

O Laravel passa a utilizar o Redis automaticamente por meio do sistema de cache (`Cache`) e do cliente Redis (`Redis`).
````
----------

## 🧠 Estratégia de Cache de Pontos Turísticos

Quando um ponto turístico é acessado pelo endpoint:

`GET /api/pontos/{id}` 

O seguinte fluxo acontece:

1.  O contador de acessos do ponto é incrementado no Redis
    
2.  O sistema verifica se os dados do ponto já estão em cache
    
3.  Caso estejam, o Redis retorna os dados imediatamente
    
4.  Caso contrário, os dados são buscados no banco relacional e armazenados no cache
    

### 🔹 Implementação no Service
````
public function find(int $id)
{
    // Incrementa contador de acessos no Redis
    Redis::incr("ponto_acessos_{$id}");

    // Cacheia os dados do ponto turístico por 60 segundos
    return Cache::remember("ponto_{$id}", 60, function () use ($id) {
        return $this->repo->find($id);
    });
}

````

### ✅ Benefícios

-   Evita múltiplas consultas repetidas ao banco
    
-   Retorna dados rapidamente
    
-   Permite controle fino do tempo de cache
    

----------

## 🔥 Invalidação de Cache (Consistência dos Dados)

Sempre que uma ação altera dados relevantes do ponto turístico, o cache correspondente é **invalidado**, garantindo que o usuário nunca veja dados desatualizados.

### 🔹 Exemplo: atualização da nota média após uma avaliação

`Cache::forget("ponto_{$pontoId}");` 

Isso garante que:

-   O próximo acesso buscará os dados atualizados no banco
    
-   O cache será recriado automaticamente com valores corretos
    

----------

## 📊 Contador de Acessos com Redis

Cada vez que um ponto turístico é acessado, um contador é incrementado no Redis:

`Redis::incr("ponto_acessos_{$id}");` 

Esse contador é utilizado para:

-   Identificar os pontos mais acessados
    
-   Criar rankings de popularidade
    
-   Alimentar a página **“Pontos mais acessados”**
    

----------

## ⭐ Página “Pontos Mais Acessados”

A funcionalidade _Mais Acessados_ é baseada diretamente nos dados armazenados no Redis.

### 🔹 Funcionamento

1.  O Redis armazena os acessos de cada ponto
    
2.  O backend lê os contadores
    
3.  Os IDs mais acessados são ordenados
    
4.  Os pontos correspondentes são buscados no banco
    
5.  A lista é enviada ao frontend
    

### ✅ Vantagens

-   Consulta extremamente rápida
    
-   Não sobrecarrega o banco relacional
    
-   Fácil escalabilidade
    

----------

## 🧩 Por que Redis e não apenas SQL?



O Redis **não substitui** o banco relacional, mas **trabalha em conjunto**, cada um cumprindo seu papel.
| Redis | Banco Relacional (SQL) |
|------|------------------------|
| Banco de dados em memória (in-memory) | Baseado em disco |
| Altíssima velocidade de leitura e escrita | Leitura e escrita mais custosas |
| Ideal para cache e dados temporários | Ideal para dados persistentes |
| Excelente para contadores e métricas | Contadores exigem mais processamento |
| Baixa latência | Maior latência em consultas frequentes |

----------

## ✅ Conclusão

A utilização do Redis neste projeto permitiu:

-   Melhor desempenho da aplicação
    
-   Menor carga no banco de dados
    
-   Implementação eficiente de métricas de acesso
    
-   Base sólida para funcionalidades futuras
    

Essa arquitetura segue boas práticas modernas de desenvolvimento backend, separando **persistência de dados**, **cache** e **métricas** de forma clara e organizada.