<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 12px; color: #aaa; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #eee; }
        .total { font-weight: bold; font-size: 18px; text-align: right; }
        .logo { font-size: 24px; font-weight: bold; color: #4F46E5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">E-Commerce Shop</div>
            <h2>Order Confirmation</h2>
            <p>Thank you for your order, {{ $order->customer_name }}!</p>
        </div>

        <p>We've received your order <strong>#{{ $order->id }}</strong> and are getting it ready.</p>

        <h3>Order Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: ₹{{ number_format($order->total_price, 2) }}
        </div>

        <h3>Shipping to:</h3>
        <p>{{ $order->shipping_address }}</p>

        <div class="footer">
            <p>If you have any questions, please reply to this email.</p>
            <p>&copy; {{ date('Y') }} E-Commerce Shop. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

