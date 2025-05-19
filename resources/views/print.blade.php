<!DOCTYPE html>
<html>

<head>
    <title>Print Label</title>
    <style>
        @page {
            size: 4cm auto;
            margin: 0;
        }

        body {
            margin: 0;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
        }

        .label {
            padding: 5px;
            border: 1px solid #000;
            border-radius: 20px;
            text-align: center;
            page-break-inside: avoid;
            margin: 5px;
        }

        .label h3 {
            font-size: 12px;
            margin: 2px 0;
        }

        .label img {
            max-width: 3.5cm;
            height: auto;
        }

        .no-print {
            display: none;
        }
    </style>
</head>

<body>
    @foreach($items as $item)
    <div class="label">
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <th colspan="3" style="text-align: center; font-size: 12px; padding-bottom: 5px;">#</th>
            </tr>
            <tr>
                <td style="padding-top: 5px; text-align: center;">
                    <img src="{{ $item['barcode'] }}" style="width: 100px; height: auto; display: block; margin: 0 auto;"><br>
                    <small style="font-size: 10px; display: block; margin-top: 0px;">{{ $item['warrantyCode'] }}</small>
                </td>
                <td style="width: 50px;">&nbsp;</td>
                <td style="padding-top: 5px; text-align: center; vertical-align: top;">
                    <img src="{{ $item['qrcode'] }}" style="width: 50px; height: auto; display: block; margin: 0 auto;">
                </td>
            </tr>
        </table>

    </div>
    @endforeach

    <script>
        window.print();
    </script>
</body>



</html>