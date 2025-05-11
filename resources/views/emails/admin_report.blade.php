<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Diário de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #222;
        }

        .summary {
            margin-top: 20px;
            font-size: 16px;
        }

        .summary p {
            margin: 8px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Resumo Diário de Vendas</h2>

        <p>Olá {{ $user->name }},</p>

        <p>Segue abaixo o resumo das vendas do dia <strong>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</strong>:</p>

        <div class="summary">
            <p><strong>Valor Total Vendido:</strong> R$ {{ number_format($totalValue, 2, ',', '.') }}</p>
        </div>

        <p>Esse relatório é gerado automaticamente com base nos dados do sistema.</p>

        <div class="footer">
            Este é um e-mail automático. Por favor, não responda.
        </div>
    </div>
</body>
</html>
