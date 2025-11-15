# Projeto: Cadastro de Estudantes e Cursos (PHP + MongoDB)
Arquivos gerados para: Henrique Nunes Peixoto – RA 60300275
Rodrigo Valim Junior – RA 60000597
Maria Fernanda Bandeira Gobo - RA 60300664

## Descrição
Projeto mínimo em PHP que demonstra:
- Cadastro de estudantes (com endereço).
- Cadastro de cursos.
- Relacionamento many-to-many via coleção `enrollments`.
- Interface simples usando Bootstrap 5.
- Conexão com MongoDB (Atlas ou local) via driver `mongodb/mongodb`.

**Atenção:** Não inclua suas credenciais em repositórios públicos. Use `.env`.

## Como usar
1. Instale dependências: `composer install`
2. Copie `.env.example` para `.env` e configure `MONGODB_URI` e `MONGODB_DB`.
3. Inicie servidor PHP apontando `public/` como docroot:
   `php -S localhost:8000 -t public`
4. Acesse `http://localhost:8000`

## Observações
- Este pacote não inclui credenciais.
- Foi preparado pelos estudantes listados acima.
