<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Калькулятор ЕГЭ</title>
</head>
<body style="margin: 50px;">
    <h1>Калькулятор ЕГЭ</h1>

    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="checkbox" name="filter1" id="filter1">
        <label for="filter1">Русский язык</label>
        <br>
        <input type="checkbox" name="filter2" id="filter2">
        <label for="filter2">Математика – профильная</label>
        <br>
        <input type="checkbox" name="filter3" id="filter3">
        <label for="filter3">Физика</label>
        <br>
        <input type="checkbox" name="filter4" id="filter4">
        <label for="filter4">Информатика и ИКТ</label>
        <br>
        <input type="checkbox" name="filter5" id="filter5">
        <label for="filter5">Химия</label>
        <br>
        <input type="checkbox" name="filter6" id="filter6">
        <label for="filter6">Биология</label>
        <br>
        <input type="checkbox" name="filter7" id="filter7">
        <label for="filter7">Архитектурный рисунок (Творческое испытание )</label>
        <br>
        <input type="checkbox" name="filter8" id="filter8">
        <label for="filter8">Академический рисунок (Творческое испытание )</label>
        <br>
        <input type="checkbox" name="filter9" id="filter9">
        <label for="filter9">Обществознание</label>
        <br>
        <input type="checkbox" name="filter10" id="filter10">
        <label for="filter10">История</label>
        <br>
        <input type="checkbox" name="filter11" id="filter11">
        <label for="filter11">Иностранный язык</label>
        <br>
        <input type="submit" value="Рассчитать">
    </form>

    <table  class="table">
        <thead>
            <tr>
                <th>Факультет</th>
                <th>Направление, специальность</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'vendor/autoload.php';

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load("ege-calc.xlsx");
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $columns = array('a', 'd', 'e', 'f', 'g', 'h');
            $filterNames = array(
                'filter1' => 'Русский язык',
                'filter2' => 'Математика – профильная',
                'filter3' => 'Физика',
                'filter4' => 'Информатика и ИКТ',
                'filter5' => 'Химия',
                'filter6' => 'Биология',
                'filter7' => 'Архитектурный рисунок (Творческое испытание )',
                'filter8' => 'Академический рисунок (Творческое испытание )',
                'filter9' => 'Обществознание',
                'filter10' => 'История',
                'filter11' => 'Иностранный язык'
            );

            $filters = [];
            foreach ($_GET as $filter => $value) {
                $filters[] = $filterNames[$filter];
            }

            for ($row = 2; $activeWorksheet->getCell("a$row")->getValue() != ''; $row++) {
                // Get a record out of the table
                $record = [];
                foreach ($columns as $column) {
                    $record[] = $activeWorksheet->getCell("$column$row")->getValue();
                }

                // Check if the record has chosen filters
                $containsSearch = count(array_intersect($filters, $record)) === count($filters);
                if (!$containsSearch) {
                    continue;
                }

                // Show the record
                echo "<tr>";
                foreach ($record as $part) {
                    echo "<td>$part</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>