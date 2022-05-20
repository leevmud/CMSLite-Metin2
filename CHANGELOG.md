# CMSLite
Mais informações estão disponíveis em: https://www.levmud.com

## [2.4.1] - 2022-05-20
### Changed
- Melhorias na conexão com o banco de dados e na forma como as queries eram executadas. 
### Added
- Opção para ativar/desativar header e footer customizados nas páginas;
- Nova página adicionada para exibir quando a conexão com o banco de dados falhou(You can edit in: /template/default/offline.html)
- Timer para reenviar e-mails(Padrão de 5min, pode alterar o tempo no init.php)
- Verificação com captcha para troca de senha e email.

### Fixed
- Caminho do template e arquivos quando o site era utilizado em subpastas.

## [1.2.1] - 2022-03-01
### Changed
- Criação de Contas e Login foram alterados para páginas individuais.
- Melhorada a forma como os jogadores 'Top Classe' são trazidos.

### Added
- Adicionado opção 'ENABLE_CAPTCHA' no /vendor/init.php para melhor utilização em ambientes de testes.

### Fixed
- Corrigido erro ao tentar logar com usuário inexistente se a opção de BLOCK_LOGIN_SITE_USER_BAN estiver ativa.
- Corrigido possibilidade de ver postagens que foram 'excluidas'.

## [0.1.0] - 2022-02-08
### Changed
- Alterações nas rotas do site de português para inglês.

### Added
- Adicionado no arquivo query.sql, comando para criar coluna register_ip na tabela account.
- Adicionado arquivo de tradução para Inglês.

### Removed
- Removidos arquivos de exemplo e testes que não eram utilizados.