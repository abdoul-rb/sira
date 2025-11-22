<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Facture {{ $order->order_number }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .company-info {
            float: left;
            width: 50%;
        }

        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 10px;
            border: 1px solid gainsboro;
            border-radius: 5px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .client-info {
            margin-bottom: 30px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            float: right;
            width: 40%;
        }

        .totals table {
            margin-bottom: 0;
        }

        .totals td {
            border-bottom: 1px solid #eee;
        }

        .totals .grand-total {
            font-weight: bold;
            font-size: 14px;
            background-color: #f4f4f4;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .badge-paid {
            background-color: #10b981;
        }

        .badge-pending {
            background-color: #f59e0b;
        }

        .badge-cancelled {
            background-color: #ef4444;
        }

        .badge-credit {
            background-color: #3b82f6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header clearfix">
            <div class="company-info">
                @if($company->logo_path && file_exists(public_path('storage/' . $company->logo_path)))
                    <img src="{{ public_path('storage/' . $company->logo_path) }}" class="logo" alt="{{ $company->name }}">
                @endif

                <h1 style="color: black">
                    {{ $company->name }}
                </h1>

                <p>
                    {{ $company->address }}<br>
                    Tél: {{ $company->phone_number }}<br>
                    Email: {{ $company->email }}
                </p>
            </div>

            <div class="invoice-info">
                <h2>FACTURE</h2>
                <p>
                    <strong>N° :</strong> {{ $order->order_number }}<br>
                    <strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                    <strong>Statut :</strong>
                    @if($order->status === \App\Enums\OrderStatus::PAID)
                        PAYÉE
                    @elseif($order->status === \App\Enums\OrderStatus::PENDING)
                        EN ATTENTE
                    @elseif($order->status === \App\Enums\OrderStatus::CANCELLED)
                        ANNULÉE
                    @endif
                </p>
            </div>
        </div>

        <div class="client-info">
            <h3 style="margin-top: 0; margin-bottom: 10px;">Facturer à :</h3>
            <strong>{{ $customer->fullname }}</strong><br>
            @if($customer->address) {{ $customer->address }}<br> @endif
            @if($customer->email) {{ $customer->email }} @endif
            @if($customer->phone_number) / {{ $customer->phone_number }} @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-center">Qté</th>
                    <th class="text-right">Prix Unit.</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->productLines as $item)
                    <tr>
                        <td>
                            {{ $item->product->name }}
                        </td>
                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-right">
                            {{ number_format((float) $item->unit_price, 0, ',', ' ') }} F CFA
                        </td>
                        <td class="text-right">
                            {{ number_format((float) $item->total_price, 0, ',', ' ') }} F CFA
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix">
            <div class="totals">
                <table>
                    <tr>
                        <td>
                            <strong>Sous-total</strong>
                        </td>
                        <td class="text-right">
                            {{ number_format((float) $order->subtotal, 0, ',', ' ') }} F CFA
                        </td>
                    </tr>
                    @if($order->discount > 0)
                        <tr>
                            <td>Remise</td>
                            <td class="text-right">
                                - {{ number_format((float) $order->discount, 0, ',', ' ') }} F CFA
                            </td>
                        </tr>
                    @endif

                    <tr class="grand-total">
                        <td>Total</td>
                        <td class="text-right">
                            {{ number_format((float) $order->total_amount, 0, ',', ' ') }} F CFA
                        </td>
                    </tr>

                    @if($order->advance > 0)
                        <tr>
                            <td>Avance payée</td>
                            <td class="text-right">
                                {{ number_format((float) $order->advance, 0, ',', ' ') }} F CFA
                            </td>
                        </tr>
                    @endif

                    @if($order->payment_status === \App\Enums\PaymentStatus::CREDIT || $order->advance < $order->total_amount)
                        <tr>
                            <td style="color: slategrey">
                                <strong>Reste à payer</strong>
                            </td>
                            <td class="text-right" style="color: slategrey;">
                                <strong>
                                    {{ number_format((float) $order->total_amount - (float) $order->advance, 0, ',', ' ') }}
                                    F CFA
                                </strong>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="footer">
            <p>Merci de votre confiance !</p>
            <p>{{ $company->name }} - {{ $company->email }}</p>
        </div>
    </div>
</body>

</html>