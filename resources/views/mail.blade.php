<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informaçãoes do Boleto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <h1>Informações do Boleto</h1>
    <p>Prezado(a) Gestor da {{ $mailMessage->company_name}},</p>

    <p>Segue abaixo as informações do seu boleto:</p>

    <p><strong>Código de Barras:</strong> {{ $mailMessage->bar_code }}</p>
    <p><strong>Valor:</strong> R$ {{ $mailMessage->value }}</p>

    @if (strtotime($mailMessage->due_date) < strtotime(date('Y-m-d')))
        <p>Seu boleto está vencido. Foram aplicados juros de {{ $mailMessage->fees }}% ao valor do boleto.</p>
    @else
        <p>O boleto está dentro do prazo de vencimento. Por favor, realize o pagamento até a data de vencimento para evitar juros e multas.</p>
    @endif

    <p>Se tiver alguma dúvida, não hesite em entrar em contato conosco.</p>

    <p>Atenciosamente,</p>
    <p><strong>Techno Software©</strong></p>
</body>