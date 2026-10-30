
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Resposta em formato JSON
header('Content-Type: application/json; charset=utf-8');

// Função para responder ao JavaScript
function responder($success, $message, $status = 200)
{
    http_response_code($status);

    echo json_encode([
        'success' => $success,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Permitir apenas pedidos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método não permitido.', 405);
}

// Receber os dados
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// Validar campos obrigatórios
if (
    $nome === '' ||
    $email === '' ||
    $assunto === '' ||
    $mensagem === ''
) {
    responder(false, 'Preencha todos os campos obrigatórios.', 422);
}

// Validar o e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'O endereço de e-mail é inválido.', 422);
}

// Impedir caracteres de quebra de cabeçalho
if (
    preg_match('/[\r\n]/', $nome) ||
    preg_match('/[\r\n]/', $email) ||
    preg_match('/[\r\n]/', $assunto)
) {
    responder(false, 'Foram encontrados caracteres inválidos.', 422);
}

// Limites dos campos
if (
    mb_strlen($nome) > 100 ||
    mb_strlen($email) > 254 ||
    mb_strlen($assunto) > 150 ||
    mb_strlen($mensagem) > 5000
) {
    responder(
        false,
        'Um ou mais campos ultrapassaram o limite permitido.',
        422
    );
}

try {

    // Carregar o PHPMailer
    require __DIR__ . '/../vendor/autoload.php';

    // Carregar as configurações SMTP
    $config = require __DIR__ . '/../config/mail.php';

    // Criar o objeto de envio
    $mail = new PHPMailer(true);

    // Configurar SMTP
    $mail->isSMTP();
    $mail->Host = $config['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['username'];
    $mail->Password = $config['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $config['port'];

    // Configurações gerais
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(false);

    // Remetente: conta Gmail autenticada
    $mail->setFrom(
        $config['username'],
        'Formulário do site'
    );

    // Destinatário
    $mail->addAddress($config['recipient']);

    // Permitir responder diretamente ao visitante
    $mail->addReplyTo($email, $nome);

    // Conteúdo do e-mail
    $mail->Subject = 'Novo contacto: ' . $assunto;

    $mail->Body =
        "NOVO CONTACTO RECEBIDO PELO SITE\n\n" .
        "Nome: {$nome}\n" .
        "E-mail: {$email}\n" .
        "Assunto: {$assunto}\n\n" .
        "Mensagem:\n{$mensagem}";

    // Enviar
    $mail->send();

    responder(
        true,
        'Mensagem enviada com sucesso! Obrigado pelo contacto.'
    );

} catch (Throwable $erro) {

    // Registar o erro no log do servidor
    error_log('Erro no envio do formulário: ' . $erro->getMessage());

    // Não revelar detalhes técnicos ao visitante
    responder(
        false,
        'Não foi possível enviar a mensagem. Tente novamente mais tarde.',
        500
    );
}
