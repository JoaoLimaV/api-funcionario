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

    public function sendConfirmOrder($email, $customerName, $orderNumber, $deliveryPrice, $saleDiscount, $salePrice, $saleTotal, $status, $products) {
        try {
            //Recipients
            $this->mail->setFrom('jellytronic.store@gmail.com', 'JellyTronic');
            $this->mail->addAddress($email, '');
            // $this->mail->addReplyTo('jellytronic.store@gmail.com', 'Information');

            //Content
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';                                
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
                            <p>Olá, $customerName. A equipe JellyTronic informa,</p>
                            <p>Seu pedido de número <strong>#$orderNumber</strong> $status</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">

                        <p class="title_pedido">Resumo do Pedido:</p>
                            <div style="color: gray;">
                                <p> <strong> Frete: </strong>R$ $deliveryPrice</p>
                                <p> <strong> Descontos: </strong>$saleDiscount%</p>
                                <p> <strong> Preço a pagar: </strong>R$ $salePrice</p>
                                <p> <strong> Envio Total: </strong>R$ $saleTotal</p>
                            </div>
                        </p>

                            <p class="title_pedido">Produtos do Pedido:</p>
                            $products
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
            $htmlContent = str_replace('$customerName', $customerName, $htmlContent);
            $htmlContent = str_replace('$orderNumber', $orderNumber, $htmlContent);
            $htmlContent = str_replace('$deliveryPrice', $deliveryPrice, $htmlContent);
            $htmlContent = str_replace('$saleDiscount', $saleDiscount, $htmlContent);
            $htmlContent = str_replace('$salePrice', $salePrice, $htmlContent);
            $htmlContent = str_replace('$saleTotal', $saleTotal, $htmlContent);
            $htmlContent = str_replace('$status', $status, $htmlContent);

            $productHtml = '';
            foreach ($products as $product) {
                $productHtml .= '<div class="infoProd">';
                $productHtml .= '<div class="product-image">';
                $productHtml .= '<img src="' . $product['image_url'] . '" alt="" width="100%">';
                $productHtml .= '</div>';
                $productHtml .= '<div class="product-info">';
                $productHtml .= '<p><strong>Produto:</strong> ' . $product['name'] . '</p>';
                $productHtml .= '<p><strong>Preço unitário:</strong> R$ ' . number_format($product['price'], 2, ',', '.') . '</p>';
                $productHtml .= '<p><strong>Quantidade:</strong> ' . $product['quantity'] . '</p>';
                $productHtml .= '</div>';
                $productHtml .= '</div>';
            }

            $htmlContent = str_replace('$products', $productHtml, $htmlContent);

            $this->mail->Body = $htmlContent;

            

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Error: {$this->mail->ErrorInfo}";
        }
    }
}