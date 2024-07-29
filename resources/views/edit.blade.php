<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sheets Import</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="container-sm my-5">
        <h2>Atualizar Dados</h2>

        <form action="{{ route('financials.update', $financials->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group my-3">
                <label for="company_name">Nome Fantasia:</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $financials->company_name }}" required>
            </div>

            <div class="form-group my-3">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $financials->email }}" required>
            </div>

            <div class="form-group my-3">
                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $financials->cnpj }}" required>
            </div>

            <div class="form-group my-3">
                <label for="bar_code">Código de Barras:</label>
                <input type="text" class="form-control" id="bar_code" name="bar_code" value="{{ $financials->bar_code }}" required>
            </div>

            <div class="form-group my-3">
                <label for="value">Valor:</label>
                <input type="text" class="form-control" id="value" name="value" value="{{ $financials->value }}" required>
            </div>

            <div class="form-group my-3">
                <label for="due_date">Vencimento:</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $financials->due_date }}" required>
            </div>

            <div class="form-group my-3">
                <label for="fees">Juros:</label>
                <input type="number" min="0" max="100" step=".01"class="form-control" id="fees" name="fees" value="{{ $financials->fees }}" required>
            </div>

            <button type="submit" class="btn btn-primary my-3">Atualizar</button>
        </form>
    </div>
</body>
