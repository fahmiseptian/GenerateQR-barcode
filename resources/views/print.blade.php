<!DOCTYPE html>
<html>

<head>
    <title>Print Label</title>

    <style>
        @page {
            size: 24mm auto;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .label {
            page-break-after: always;
            width: 100%;
            height: 24mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            padding: 0 4mm;
            gap: 6mm;
        }


        .barcode-container,
        .qrcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .barcode-container img {
            height: 10mm;
            max-width: 28mm;
        }

        .qrcode-container img {
            height: 18mm;
            max-width: 18mm;
        }

        .warranty-code {
            font-size: 9px;
            margin-top: 1mm;
            text-align: center;
        }

        .logo-text {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 2mm;
        }
    </style>

</head>

<body>

    @foreach($items as $item)
    <div class="label" style="display: flex; align-items: center; justify-content: center;">
        <div class="detail-company">
            <div class="logo-text">LOGO</div>
            <div class="company-name">PT. ABC</div>
            <div class="company-address">Jl. Raya No. 123, Jakarta</div>
        </div>
        <div class="barcode-container">
            <img src="{{ $item['barcode'] }}" style="display: block; margin: auto;">
            <div class="warranty-code" style="text-align: center;">{{ $item['warrantyCode'] }}</div>
        </div>
        <div class="qrcode-container">
            <img src="{{ $item['qrcode'] }}" style="display: block; margin: auto;">
        </div>
    </div>
    @endforeach



    <script>
        window.print();
    </script>

</body>

</html>