# Agenda de Estudos — exemplo didático de Back-end I

Aplicação pequena em **PHP puro** para demonstrar os requisitos do Trabalho Final de 2026/2: entidade, cadastro, login/logout, sessão, cookie, validações, interface e persistência em JSON.

## Pré-requisitos

- PHP **8.1 ou superior**, com extensões padrão `json` e `pcre`.
- Pasta `storage/` com permissão de escrita pelo PHP.
- Não precisa de MySQL, Composer nem frameworks.

## Executar localmente

### XAMPP ou WampServer

1. Copie a pasta `Agenda_Estudos_Exemplo_Didatico` para `htdocs` (XAMPP) ou `www` (WampServer).
2. Inicie o Apache.
3. Acesse `http://localhost/Agenda_Estudos_Exemplo_Didatico/public/`.
4. Cadastre um usuário com e-mail de teste e senha de pelo menos 8 caracteres.

> **Atenção:** o ideal para aplicações reais é configurar o Apache para servir somente a pasta `public/`. Neste exemplo, `storage/.htaccess` também bloqueia acesso direto aos dados quando o Apache respeita `.htaccess`. Não publique esse projeto na internet sem uma revisão de segurança e a configuração correta do servidor.

### Servidor embutido do PHP

Na raiz da pasta, execute:

```bash
php -S localhost:8000 -t public
```

Abra `http://localhost:8000/`. Este servidor é apenas para desenvolvimento.

## Organização

| Caminho | Responsabilidade |
|---|---|
| `config/app.php` | Inicia sessão e importa os arquivos necessários |
| `classes/Tarefa.php` | **Entidade**: ID, título, matéria, prazo, prioridade e controles |
| `funcoes/geral.php` | Funções de formulários, CSRF, cookies, saída segura e redirecionamento |
| `funcoes/autenticacao.php` | Identifica e protege usuário autenticado |
| `funcoes/arquivos.php` | Leitura e gravação de JSON |
| `public/` | Páginas e scripts acessados pelo navegador |
| `views/` | Cabeçalho e rodapé de HTML reutilizáveis |
| `storage/` | Usuários e tarefas persistidos fora de `public/` |

