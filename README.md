
<p align="center"> <img src="http://i.imgur.com/6KXNtkF.png" alt="ChatBotPHP"/> </p>

----------

## ChatBot Para Messenger Feito Em PHP

----------

   - Atendente Para Paginas
   - Facil Configuração
   - Menor Tempo De Resposta
   - Integração Com Banco De Dados
   - Facil manutenção

----------

#### **Demo:** https://fb.com/capaspersonalizadaass
#### **Note:** Abra o chat da pagina e envie **help**
    

----------

 1. Acesse o Painel De Desenvolvedores do Facebook **https://developers.facebook.com**

 
	 * Meus Aplicativos > Adicionar Aplicativo
	 * Nome De Exibiçao > De sua Preferencia
	 * Clique no Botão > Crie um número de identificação do aplicativo.
	
 2. Aplicativo Criado

	##### Com o Aplicativo já criado  No menu vá em  **Adicionar Produto**
	

 3. Configurando o Messenger

	##### Clique Encima do Botão Começar na Opção **"Messenger"**

 4. Configuraçoes

	##### Com o Messenger Adicionado Vá em **Webhooks** E Clique em **Configurar Webhooks**

 5. Configurando WebHooks


	- Em **URL de retorno de chamada:** coloque o https://seudominio.com/webhooks.
	- **Senha:** Abra o arquivo **/config/config.php** e atribua uma senha para verificaçao no webhooks.
	```php
		define("TOKEN_ACCESS", "sua senha");
   	```
	- Em **Verificar token:** o valor definido em TOKEN_ACCESS.
	- Em **Campos de Assinatura:** selecione **messages, messaging_postbacks, message_deliveries, message_reads**
	- Apos seguir os passos clique em **Verificar e Salvar**
	
	
 6. Configurando Servidor PHP

	Apos a verificaçao ser bem sucedida.
	
	- **Key:** Abra o arquivo **/views/webhooks.php** procure a variavel $key coloque o token da pagina desejada para o BOT. 
	- **Para gerar a KEY:** vá ate **Geração de token** acima de Webhooks em **Pagina** selecione a pagina desejada para o BOT. Ira Abrir uma janela pedindo a permissão da pagina para o acesso do Facebook Developers. Apos Aceitar em **Token de acesso da Página** ira aparecer um Token copie ele e coloque na variavel $key em **/views/webhooks.php**.


 7. Configurar Mensagens

	Para Configurar bastar ir ate **neural/neuro-system.json** 
	> **Note:**
	> - As mensagens são configuradas em JSON.



 # Ajude o Projeto
 
___________

<p align="center"><img src="http://imgur.com/qtrPadk.jpg" width="90" /> 37RWdwgsXK94pANXm9fHv722k4zQmtmCpH  </p> 

--------------------------

<p align="center"><img src="https://chart.googleapis.com/chart?chs=240x240&choe=UTF-8&chld=M%7C0&cht=qr&chl=37RWdwgsXK94pANXm9fHv722k4zQmtmCpH" width="200"/></p> 

--------------------------

<p align="center"><img src="http://i.imgur.com/PJNAV7l.png" width="90" /> https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=PBUWHQ3WASDAA </p> 

--------------------------
