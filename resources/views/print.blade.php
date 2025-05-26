<!DOCTYPE html>
<html>

<head>
    <title>Print Label</title>

    <style>
        @page {
            size: 36mm auto;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
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
    <div class="company-name" style="font-weight: bolder; font-family: 'Algerian','Courier'; margin-top: 2mm; font-size: 25px;">PT. INTI <span class="company-name">TUNGGAL</span></div>

    <div class="label" style="display: flex; align-items: center; justify-content: center; ">
        <div class="detail-company">
            <table style="width: 100%; margin-top: 10mm;">
                <tr>
                    <td>(021) 6477 8899</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>www.intitunggal.com</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div class="company-address" style="text-align: justify; margin-top: 4mm;"> <small> Jl. Malaka II (d/h. Jl. Orpa) No. 23 A-B Jakarta 11230 - Indonesia</small></div>
        </div>
        @if($showBarcode)
        <div class="barcode-container" style="margin-top: 7mm;">
            <img src="{{ $item['barcode'] }}" style="display: block; margin: auto;">
            <div class="warranty-code" style="text-align: center;">{{ $item['warrantyCode'] }}</div>
        </div>
        @endif
        @if($showQrcode)
        <div class="qrcode-container" style="margin-top: 7mm;">
            <img src="{{ $item['qrcode'] }}" style="display: block; margin: auto;">
        </div>
        @endif
    </div>
    @endforeach



    <script>
        window.print();
    </script>

</body>

</html>