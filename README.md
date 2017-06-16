ChatBot Atendente Para Paginas!
===================
----------
![enter image description here](https://s-media-cache-ak0.pinimg.com/originals/3a/b3/e9/3ab3e96ae8a4eb18f9eba02615c8e3c3.gif)

Passo 1
-------------

Acesse o Painel De Desenvolvedores do Facebook **https://developers.facebook.com**

> **Note:**

> - Meus Aplicativos > Adicionar Aplicativo
> - Nome De Exibiçao > De sua Preferencia
> -  Clique no Botão > Crie um número de identificação do aplicativo.

#### <i class="icon-file"></i> Aplicativo Criado

<i class="icon-folder-open"></i> Com o Aplicativo já Criado 
 <i class="icon-file"></i> No menu vá em  **Adicionar Produto**

#### <i class="icon-folder-open"></i> Configurando o Messenger

Clique Encima do Botão Começar na Opção "Messenger"

#### <i class="icon-pencil"></i> Configuraçoes

Com o Messenger Adicionado Vá em **Webhooks** E Clique em **Configurar Webhooks**

#### <i class="icon-trash"></i> Configurando WebHooks

Em **URL de retorno de chamada:** coloque o https://seudominio.com/webhooks.
> **Senha:** Abra o arquivo **/views/webhooks.php** procure a variavel $senha no mesmo arquivo e atribua uma senha para verificaçao no webhooks.
Em **Verificar token:** o valor da variavel $senha definida.
Em **Campos de Assinatura:** selecione **messages, messaging_postbacks, message_deliveries, message_reads**
Apos seguir os passos clique em **Verificar e Salvar**

#### <i class="icon-hdd"></i> Configurando Servidor PHP

Apos a verificaçao ser bem sucedida.

> **Key:** Abra o arquivo **/views/webhooks.php** procure a variavel $key coloque o token da pagina desejada para o BOT. 
> **Para gerar a KEY:** vá ate **Geração de token** acima de Webhooks em **Pagina** selecione a pagina desejada para o BOT. Ira Abrir uma janela pedindo a permissão da pagina para o acesso do Facebook Developers. Apos Aceitar em **Token de acesso da Página** ira aparecer um Token copie ele e coloque na variavel $key em **/views/webhooks.php**.
Configurar Mensagens
-------------------

Para Configurar bastar ir ate **neural/neuro-system.json** 

> **Note:**

> - As mensagens são configuradas em JSON.
___________

 - **Ajude o PROJETO**
 _________
 -  ![enter image description here](https://st2.depositphotos.com/1915171/5351/v/110/depositphotos_53514081-stock-illustration-bitcoin-sign-icon-cryptography-currency.jpg) Endereço: **37RWdwgsXK94pANXm9fHv722k4zQmtmCpH**
 - Codigo QR:  ![enter image description here](https://chart.googleapis.com/chart?chs=240x240&choe=UTF-8&chld=M%7C0&cht=qr&chl=37RWdwgsXK94pANXm9fHv722k4zQmtmCpH)
 _________
 - ![enter image description here](data:image/png;base64,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)
 - [Ajudar pelo Paypal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=PBUWHQ3WASDAA)

