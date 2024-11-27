<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció zárva</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <h2 class="heading-section main-title">Regisztráció zárva!</h2>
                <br>
                <img src="public/images/mountex.jpg" width=130px>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-4">
                <p class="mt-3">Jelenleg nem lehet regisztrálni edzésre!
                    <br><small>(regisztrálni csak az edzés ideje alatt és az azt megelőző 1 órával lehetséges).</small>
                </p>
                <p>Az edzésidőpontok:</p>
                <ul class="list-group">
                    <!-- training schedule -->
                    <?php foreach ($sessions as $day => $times): ?>
                        <?php foreach ($times as $time): ?>
                            <li class="list-group-item"><?= htmlspecialchars($day) ?>: <?= htmlspecialchars($time[0]) ?>-<?= htmlspecialchars($time[1]) ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
                <p class="mt-3">Kérjük, térj vissza később!</p>
            </div>
        </div>
    </div>
</body>

</html>