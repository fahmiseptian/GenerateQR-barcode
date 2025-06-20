<!DOCTYPE html>
<html>

<head>
    <title>Print Label</title>

    <style>
        @page {
            size: auto;
            /* biarkan auto, agar tidak maksa tinggi */
            margin: 0;
        }

        @media print {
            .label {
                page-break-after: always;
                break-after: always;
                padding: 5mm;
            }

            img {
                max-width: 100%;
                height: auto;
            }

            p {
                font-size: 10px;
                text-align: center;
                margin: 4px 0;
            }
        }
    </style>
</head>

<body>

    @foreach($items as $item)
    <div class="label">
        @if($showBarcode)
        <div class="barcode-container">
            <img src="{{ $item['barcode'] }}">
            <div class="warranty-code">{{ $item['warrantyCode'] }}</div>
        </div>
        @endif
        @if($showQrcode)
        <div class="qrcode-container">
            <img src="{{ $item['qrcode'] }}">
        </div>
        @endif
        <p>
            www.intitunggal.com <br>
            cs.service@itej.co.id
        </p>
    </div>
    @endforeach


    <script>
        window.print();
    </script>

</body>

</html>