# Dog Breed - Guia de Utilização

Este repositório contém um módulo personalizado chamado "Dog Breed" que permite criar e gerenciar informações sobre raças de cães. O módulo integra-se com uma API de raças de cães e oferece recursos para automatizar a obtenção do nome global das raças e imagens aleatórias de caẽs de determinada raça.

## Índice

1. [Instalação](#instalação)
2. [Atualização do Módulo](#atualização-do-módulo)
3. [Desinstalação](#desinstalação)
4. [Detalhes do Módulo](#detalhes-do-módulo)
5. [Operações Adicionais](#operações-adicionais)
6. [Geração de Conteúdo](#geração-de-conteúdo)
7. [Visualização Personalizada](#visualização-personalizada)

## Instalação

Para utilizar o módulo "Dog Breed" em um projeto Drupal já existente, siga estas etapas:

1. Baixe apenas o módulo custom/dogbreed e o tema custom/dogbreed_theme deste repositório.
2. Copie os arquivos de `custom-module` para o diretório `web/modules/custom/` do seu projeto local.
3. Copie os arquivos de `custom-theme` para o diretório `web/themes/custom/` do seu projeto local.
4. Ative o módulo usando o Drush: `drush en dogbreed`
5. Atualize a base de dados: `drush updb`. Caso esse comando retorne mansagem de que não há atualizações pendentes: 
`Ajuste os números dos hook_update_N no arquivo dogbreed.install para adequar a realidade do schema da sua base e reconhecer os updates, que são fundamentais para o sucesso da instalação:`

![Resultado do comando drush updb](web/themes/custom/dogbreed_theme/images/hook_update_N.png)

Esse procedimento também é o mesmo caso você queria realizar uma atualização periódica dos vocabulários e termos de taxonomia.

6. Via painel administrativo: Instale o tema "dogbreed_theme" e defina-o como padrão. DICA: Se você está usando um recurso como o "Theme Switcher", você pode associar apenas o tipo de conteúdo "ctype_dogbreed" ao tema "dogbreed_theme", sem precisar alterar o tema padrão de sua base.
7. Ative os campos relacionados ao tipo de conteúdo, conforme desejado na exibição de formulário.
8. Acesse a rota /admin/config/dogbreed como administrador e defina uma raça padrão, por exemplo "Akita". Lembre-se que deve ser uma raça existente na API. Como criamos termos de taxonomia referentes as raças listadas pela API, você pode consultar o vocabulário /admin/structure/taxonomy/manage/taxonomies_dogbreeds/overview para escolher uma raça que melhor lhe agrade. Esse campo poderia já ser uma referência ao vocabulário, todavia o enunciado do desafio dizia: "Você pode presumir que o administrador adicionará um valor válido." Portanto, preferi entender isso como um requisito e criar um campo de texto simples.
9. Limpe completamente o cache do Drupal: `drush cr`
10. Acesse seu site no navegador.

## Atualização do Módulo

Ao atualizar o módulo "Dog Breed", o hook_update...

 1. Ativa o campo breed_name;
 2. Obtém as raças da API e popula como termos de taxonomia;
 3. Cria a view importando um arquivo de configuração;
 4. Cria 10 nodes do tipo ctype_dogbreed através de Devel Generate.

## Desinstalação

Ao desinstalar o módulo "Dog Breed", os seguintes elementos serão eliminados:

- Tipo de Conteúdo criado.
- Vocabulário de Taxonomia criado.
- Visualização personalizada.
- Submódulo custom_mail_redirect, devolvendo assim o controle do serviço MailManager ao Drupal padrão.

Certifique-se de que você tem um backup adequado antes de desinstalar o módulo.

## Detalhes do Módulo

- **Versões Utilizadas:**
  - Drupal: 9.5.10
  - Drush: 11.6.0
  - PHP: 8.1.18
  - Hospedagem: Simulada localmente usando Lando v3.18.0

- **Características do Módulo:**
  - Criação automática do tipo de conteúdo no momento da ativação.
  - Criação automática de um vocabulário de taxonomia para raças de cães no momento da ativação.
  - Visualização personalizada criada via importação do arquivo `views.view.view_custom_dogbreeds.yml`.

## Recursos

O módulo "Dog Breed" inclui os seguintes recursos:

- Criação de um vocabulário de taxonomia para armazenar as raças de cães.
- Tela de configuração programaticamente criada para que o administrador possa definir uma raça padrão.
- Tema personalizado "dogbreed_theme" baseado no subtema "bootstrap_barrio".
- Bloco customizado programaticamente para obter imagens aleatórias da raça padrão definida pelo administrador.
- O submódulo custom_mail_redirect, criado como dependência para redirecionar todos os e-mails para nope@doesntexist.com.

## Geração de Conteúdo

Para gerar conteúdo de exemplo, você pode usar o módulo Devel Generate. Execute o seguinte comando para criar novos nós do tipo "ctype_dogbreed":

```
drush genc 10 --bundles ctype_dogbreed
```

Adicione o parâmetro `--kill` ao comando para remover todos os registros gerados anteriormente.

## Visualização Personalizada

A view personalizada será criada automaticamente durante a instalação do módulo. Caso necessário, você pode recriar a view usando o seguinte comando:

```
drush cim --partial --source=modules/custom/dogbreed/config-partial/create-view
```

## Arquivos de configuração

Você pode preferir importar arquivos de configuração (.yml) ao invés de operar o painel administrativo. Para isso você pode executar uma importação parcial dos arquivos contidos em ../config/partial através do comando `drush cim --partial --source=../config/partial`:

Confira a relação dos arquivos de configuração referentes às configurações do módulo e tema dogbreed: 

```
block.block.dogbreed_theme_secondary_local_tasks
block.block.dogbreed_theme_primary_local_tasks
block.block.dogbreed_theme_primary_admin_actions
block.block.dogbreed_theme_page_title
block.block.dogbreed_theme_help
block.block.dogbreed_theme_syndicate
node.type.ctype_dogbreed
block.block.dogbreed_theme_search_form_wide
block.block.dogbreed_theme_search_form_narrow
block.block.dogbreed_theme_site_branding
block.block.dogbreed_theme_powered
block.block.dogbreed_theme_messages
block.block.dogbreed_theme_content
block.block.dogbreed_theme_breadcrumbs
block.block.dogbreed_theme_account_menu
block.block.dogbreed_theme_main_menu
field.storage.node.breed_name
taxonomy.vocabulary.taxonomies_dogbreeds (Desatualiza rapidamente pois a API é pública).
field.field.node.ctype_dogbreed.breed_name
views.view.view_custom_dogbreeds
dogbreed.settings
core.extension
system.theme
```

Agora você está pronto para aproveitar todas as funcionalidades do módulo "Dog Breed" em seu site Drupal! Se tiver dúvidas ou precisar de assistência, sinta-se à vontade para entrar em contato.
