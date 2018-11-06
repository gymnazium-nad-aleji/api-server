<?php
/*
 * MIT License
 * Copyright (c) 2018 Vojtech Horky
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
?>

<h2>Seznam metod</h2>
<dl>
    <?php foreach ($paths as $path) { ?>
    <dt>
        <code><?php printf('%s/%s', $base, $path['path']); ?></code>
        <?php if (isset($path['example'])) { ?>
            (<?php echo make_link('vyzkoušet', $base, $path['example']); ?>)
        <?php } ?>
    </dt>
    <dd><?php echo htmlspecialchars($path['description']); ?></dd>
    <?php } ?>
</dl>

<h2>Aktuální data v databázi</h2>
<?php foreach ($tables as $table) { ?>
    <h3><?php echo htmlspecialchars($table['title']); ?></h3>
    <?php if (count($table['rows']) > 0 ) { ?>
    <table class="results">
        <thead>
            <tr>
                <?php foreach ($table['cols'] as $col) { ?>
                    <td><?php echo htmlspecialchars($col); ?></td>
                <?php } ?>
            </tr>
        </thead>
        <?php foreach ($table['rows'] as $row) { ?>
        <tr>
            <?php foreach ($table['cols'] as $col) { ?>
                <td><?php echo htmlspecialchars($row[$col]); ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
        <p>Žádná data.</p>
    <?php } ?>
<?php } ?>
