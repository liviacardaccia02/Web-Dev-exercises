<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th span="col" id="key">Chiave</th>
                <th span="col" id="value">Valore</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $element): ?>
                <tr>
                    <td headers="key"><?= $element["chiave"] ?></td>
                    <td headers="value"><?= $element["valore"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>