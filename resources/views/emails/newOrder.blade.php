<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid black;
        padding: 10px;
    }
</style>

<body>
    <table style="">
        <tr>
            <td style="">Імʼя</td>
            <td>{{ $client_name }}</td>
        </tr>

        <tr>
            <td>Пошта</td>
            <td>{{ $client_email }}</td>
        </tr>

        <tr>
            <td>Телефон</td>
            <td>{{ $client_phone }}</td>
        </tr>

        @isset($client_message)
            <tr>
                <td>Повідомлення</td>
                <td>{{ $client_message }}</td>
            </tr>
        @endisset
    </table>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Зображення</th>
                <th>Назва</th>
                <th>SKU</th>
                <th>Кількість</th>
                <th>Загалом</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart_content as $cart_item)
                <tr>
                    <td>{{ $cart_item->id }}</td>
                    <td>
                        <img src="{{ $cart_item->media_file->thumbnail->url }}"
                            style="
                            width: 50px;
                            height: 50px;
                            object-fit: cover;
                        " />
                    </td>
                    <td>{{ $cart_item->name['ua'] }}</td>
                    <td>{{ $cart_item->sku }}</td>
                    <td>{{ $cart_item->quantity }}</td>
                    <td>{{ $cart_item->price * $cart_item->quantity }} ₴</td>
                </tr>
        </tbody>
        @endforeach
    </table>
</body>

</html>
