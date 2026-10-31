# Formulário de Contacto Profissional

Projeto desenvolvido para praticar e demonstrar a integração entre tecnologias de desenvolvimento web, criando um formulário de contacto com validação no servidor e envio de mensagens por e-mail.

## Demonstração

🌐 **[Aceder ao formulário online](https://roy.freedev.app)**

> A versão online está hospedada num ambiente gratuito, utilizado para testes e demonstração.

## Tecnologias utilizadas

- **HTML5:** estrutura do formulário.
- **CSS3:** estilização e responsividade.
- **JavaScript:** envio assíncrono dos dados com Fetch API.
- **PHP:** processamento e validação dos dados no servidor.
- **PHPMailer:** envio de e-mails através de SMTP.
- **Composer:** gestão das dependências PHP.

## Funcionalidades

- Formulário de contacto com campos para nome, e-mail, assunto e mensagem.
- Validação dos campos no navegador e no servidor.
- Envio de mensagens sem recarregar a página.
- Feedback visual de sucesso ou erro.
- Integração com servidor SMTP.
- Separação das configurações de e-mail do código principal.

## Estrutura do projeto

```text
formulario-profissional/
│
├── config/
│   ├── .htaccess
│   └── mail.example.php
│
├── css/
│   └── style.css
│
├── js/
│   └── script.js
│
├── php/
│   └── send.php
│
├── vendor/
│
├── index.html
├── composer.json
├── composer.lock
└── .gitignore
```

## Como executar localmente

### 1. Pré-requisitos

- PHP 8.2 ou superior.
- Apache (pode ser utilizado através do XAMPP).
- Composer.
- Conta de e-mail com acesso SMTP.

### 2. Clonar o repositório

```bash
git clone https://github.com/RobisonCarvalho/Projeto-Formulario.git
```

### 3. Instalar as dependências

Dentro da pasta do projeto, executar:

```bash
composer install
```

### 4. Configurar o SMTP

Criar o arquivo `config/mail.php`, utilizando `config/mail.example.php` como referência.

Preencher as configurações com os dados do servidor SMTP.

**Importante:** não publicar credenciais, palavras-passe ou outros dados privados no GitHub.

### 5. Executar o projeto

Colocar a pasta dentro do diretório público do Apache e iniciar o servidor.

Com XAMPP, aceder através de:

```text
http://localhost/formulario-profissional/
```

## Segurança

O projeto inclui validação dos dados no servidor, tratamento de erros e separação das credenciais SMTP.

Ainda existem melhorias previstas, como proteção contra spam, limitação de envios e reforço das configurações de produção.

## Próximas melhorias

- Integrar o campo de telefone ao processamento PHP.
- Implementar proteção contra envios automáticos.
- Melhorar os mecanismos de segurança.
- Expandir as funcionalidades do formulário.

## Objetivo do projeto

Este projeto faz parte de uma série de experiências práticas com o objetivo de desenvolver competências em programação web, integração entre front-end e back-end e criação de soluções funcionais para sites institucionais.

---

**Desenvolvido por Robison Carvalho**
