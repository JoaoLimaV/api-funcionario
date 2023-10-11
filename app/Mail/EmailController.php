<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

class EmailController
{   

    private $mail;  

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        try {
            // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;            
            $this->mail->isSMTP();                                       
            $this->mail->Host       = 'smtp.gmail.com';               
            $this->mail->SMTPAuth   = true;                                 
            $this->mail->Username   = 'jellytronic.store@gmail.com';                     
            $this->mail->Password   = 'nzvu wqml zllb jjoh';            
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
            $this->mail->Port       = 465;        
        } 
        catch (Exception $e) {
            echo "ERROR <BR><BR> {$this->mail->ErrorInfo}";
        }
    }

    public function sendConfirmOrder($email) {
        try {
            //Recipients
            $this->mail->setFrom('jellytronic.store@gmail.com', 'JellyTronic');
            $this->mail->addAddress($email, '');
            // $this->mail->addReplyTo('jellytronic.store@gmail.com', 'Information');

            //Content
            $this->mail->isHTML(true);                                
            $this->mail->Subject = 'JellyTronic - Reset Password';

            $htmlContent = '<!DOCTYPE html>
            <html>
            
            <head>
                <meta charset="UTF-8">
                <title>Exemplo de E-mail</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Hanuman&family=Hanuman:wght@300&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: Hanuman, serif;
                        padding: 0;
                        margin: 0;
                        background-color: rgba(128, 128, 128, 0.3);
                        font-size: 16px;
                    }
            
                    .header {
                        background-color: rgba(255, 103, 1, 0.9);
                        text-align: center;
                        padding: 5px;
                    }
            
                    .status {
                        font-weight: bold;
                        padding: 8px;
                        background-color: rgb(247, 181, 2);
                        text-align: center;
                        border-radius: 10px;
                    }
            
                    .title_pedido {
                        border-bottom: 2px solid #000;
                        color: #000;
                    }
            
                    .infoProd {
                        display: flex;
                    }
            
                    .product-image {
                        max-width: 120px;
                    }
            
                    .product-info {
                        flex: 1;
                        padding-left: 10px;
                    }
            
                    .product-info p {
                        color: gray;
                    }
            
                    .link_complete_prod {
                        font-weight: bold;
                        padding: 15px;
                        background-color: rgb(255, 103, 1, 0.9);
                        text-align: center;
                        border-radius: 10px;
                        text-decoration: none;
                        color: #000;
                        display: inline-block;
                    }
            
                    .footer {
                        text-align: center;
                        padding: 20px;
                        background-color: rgba(128, 128, 128, 0.7);
                    }
                </style>
            </head>
            
            <body>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="header">
                            <h1 style="color: #333;">Equipe JellyTronic</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">
                            <p>Olá, {}. A equipe JellyTronic informa,</p>
                            <p>Seu pedido de número <strong>#1213</strong> com o pagamento <span class="status">PENDENTE</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">

                        <p class="title_pedido">Resumo do Pedido:</p>
                            <div style="color: gray;">
                                <p> <strong> Frete: </strong> 17,99</p>
                                <p> <strong> Descontos: </strong> 0,00</p>
                                <p> <strong> Preço a pagar: </strong> 100,00</p>
                                <p> <strong> Envio Total: </strong> 117,99</p>
                            </div>
                        </p>

                            <p class="title_pedido">Produtos do Pedido:</p>
                            <div class="infoProd">
                                <div class="product-image">
                                    <img src="https://telleconcell.com.py/storage/images/products/1685557216bVi9LhpP.png" alt="" width="100%">
                                </div>
                                <div class="product-info">
                                    <p><strong>Produto:</strong> Celular Xiaomi Redmi Note 11 Pro 5G 128GB / 6GB RAM</p>
                                    <p><strong>Preço unitário:</strong> R$ 599,99</p>
                                    <p><strong>Quantidade:</strong> 2</p>
                                </div>
                            </div>
                            <p>Acesse o link abaixo para mais informações:</p>
                            <p style="text-align: center;"><a href="https://seulink.com" class="link_complete_prod">Visualizar pedido completo</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p>Fique por dentro de nossas redes sociais.</p>
                            <a href="#" style="color: #fff; text-decoration: none; margin: 5px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/4494/4494475.png" width="40px">
                            </a>
                            <a href="#" style="color: #fff; text-decoration: none; margin: 5px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/4494/4494488.png" width="40px">
                            </a>
                            <a href="#" style="color: #fff; text-decoration: none; margin: 5px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/4494/4494494.png" width="40px">
                            </a>
                            <a href="#" style="color: #fff; text-decoration: none; margin: 5px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/4494/4494477.png" width="40px">
                            </a>
                            <p>Agradecemos a preferência!<br>JellyTronic, sempre fornecendo qualidade!</p>
                            <img src="http://144.22.137.69/ftp/images/logo/Logo_Ecommerce.png" width="200px">
                        </td>
                    </tr>
                </table>
            </body>
            
            </html>
            ';

            $this->mail->Body = $htmlContent;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Error: {$this->mail->ErrorInfo}";
        }
    }
}