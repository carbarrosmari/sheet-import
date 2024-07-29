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

    <div class="container-fluid lg">
        <div class="card my-5 border-light shadow">
            <h3 class="card-header">Importar Planilha</h3>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success" role="alert">{!! $value !!}</div>
                @endsession

                @session('error')
                    <div class="alert alert-danger" role="alert">{!! $value !!}</div>
                @endsession

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('financials.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group my-4">
                        <input type="file" name="file" class="form-control" id="file" accept=".csv">
                        <button type="submit" class="btn btn-success" id="fileBtn"><i
                                class="fa-solid fa-upload"></i> Importar</button>
                    </div>
                </form>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Fantasia</th>
                            <th>E-mail</th>
                            <th>CNPJ</th>
                            <th>Código de Barras</th>
                            <th>Valor</th>
                            <th>Data de Vencimento</th>
                            <th>Juros</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($financials as $financial)
                            <tr>
                                <td>{{ $financial->id }}</td>
                                <td>{{ $financial->company_name }}</td>
                                <td>{{ $financial->email }}</td>
                                <td>{{ $financial->cnpj }}</td>
                                <td>{{ $financial->bar_code }}</td>
                                <td class="text-end m-5">R$ {{ $financial->value }}</td>
                                <td>{{ date('d-m-Y', strtotime($financial->due_date)) }}</td>
                                <td>{{ $financial->fees }}%</td>
                                <td><a href="{{ route('financials.edit', $financial->id) }}" class="btn btn-info">Editar</a></td>
                                <td>
                                    <form action="{{ route('financials.delete', $financial->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este registro?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Deletar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('sendEmail', $financial->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja enviar este e-mail?');" style="display:inline;">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-warning">Enviar Email</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</body>

</html>
