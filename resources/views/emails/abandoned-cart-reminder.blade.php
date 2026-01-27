<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #333; }
        .item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 10px 0; }
        .item img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; margin-right: 15px; }
        .btn { display: inline-block; background-color: #2563eb; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; margin-top: 20px; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Don't forget your items!</h1>
            <p>We noticed you left some great finds in your cart.</p>
        </div>

        <h3>Your Cart Items:</h3>
        @foreach($cart->items as $item)
        <div class="item">
            <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : Storage::url($item->product->image_url) }}" alt="{{ $item->product->name }}">
            <div>
                <strong>{{ $item->product->name }}</strong><br>
                Qty: {{ $item->quantity }} x ₹{{ number_format($item->product->price, 2) }}
            </div>
        </div>
        @endforeach

        <div style="text-align: center;">
            <a href="{{ route('cart.index') }}" class="btn">Complete Your Order</a>
        </div>

        <div class="footer">
            <p>If you have any questions, reply to this email.</p>
        </div>
    </div>
</body>
</html>
