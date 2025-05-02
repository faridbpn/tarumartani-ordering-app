<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Archive Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 14px;
            color: #6b7280;
        }
        .filter-info {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .filter-info p {
            margin: 5px 0;
            font-size: 12px;
            color: #4b5563;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #dbeafe;
            border-radius: 8px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-label {
            font-size: 12px;
            color: #1e40af;
        }
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th {
            background-color: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }
        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-canceled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-failed {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            padding: 10px 0;
            border-top: 1px solid #e5e7eb;
        }
        .page-number:before {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Order Archive Report</div>
        <div class="subtitle">Generated on {{ $filterInfo['generated_at'] }}</div>
    </div>

    <div class="filter-info">
        <p><strong>Status:</strong> {{ $filterInfo['tab'] }} Orders</p>
        <p><strong>Date Range:</strong> {{ $filterInfo['date_range'] }}</p>
        <p><strong>Payment Method:</strong> {{ $filterInfo['payment_method'] }}</p>
        @if($filterInfo['search'])
        <p><strong>Search Term:</strong> "{{ $filterInfo['search'] }}"</p>
        @endif
        <p><strong>Sort By:</strong> {{ $filterInfo['sort'] }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-label">Total Orders</div>
            <div class="summary-value">{{ $filterInfo['total_orders'] }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Amount</div>
            <div class="summary-value">Rp {{ number_format($filterInfo['total_amount'], 2) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>
                    {{ $order->customer_name }}<br>
                    <span style="font-size: 11px; color: #6b7280;">Table #{{ $order->table_number }}</span>
                </td>
                <td>
                    @foreach($order->items as $item)
                    {{ $item->menuItem->name }} (x{{ $item->quantity }})<br>
                    @endforeach
                </td>
                <td>Rp {{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $order->archive_status }}">
                        {{ ucfirst($order->archive_status) }}
                    </span>
                </td>
                <td>{{ $order->archived_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Tarumartani App - Order Archive Report - Page <span class="page-number"></span></p>
    </div>
</body>
</html> 