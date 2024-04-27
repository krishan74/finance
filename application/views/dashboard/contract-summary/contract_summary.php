<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Date-wise Contracts Summary</title>
</head>
<body>
    <h1>Date-wise Contracts Summary</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Date Created</th>
                <th>Template Code</th>
                <th>Filename</th>
                <th>TemplateName</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datewise_contracts as $contract): ?>
            <tr>
                <td><?php echo $contract->currentDate; ?></td>
                <td><?php echo $contract->templateCode; ?></td>
                <td><?php echo $contract->fileName; ?></td>
                <td><?php echo $contract->templateName; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
