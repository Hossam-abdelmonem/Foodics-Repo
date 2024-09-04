<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert</title>
</head>
<body>
<p>Dear Merchant,</p>
<p>The stock for ingredient {{ $ingredientBalance->ingredient->name }} is running low. Please check your inventory.</p>
<p>Current Stock: {{ $ingredientBalance->amount }}</p>
</body>
</html>
