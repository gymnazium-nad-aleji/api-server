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


/**
 * Displays homepage of our application.
 */
function page_index($apis) {
	layout('layout/default.html.php');
	
    set('title', 'Dostupné API');
    set('apis', $apis);
    
    return html('home.html.php');
}

function page_api_overview($base, $info) {
    layout('layout/default.html.php');
    
    $tables = [];
    foreach ($info['tables'] as $table) {
        $entry = [
            'title' => $table['title'],
            'rows' => db_find_objects('table contents', $table['sql'])
        ];
        if (count($entry['rows']) > 0) {
            $entry['cols'] = array_keys($entry['rows'][0]);
        } else {
            $entry['cols'] = [];
        }
        $tables[] = $entry;
    }
    
    set('title', $info['title']);
    set('base', $base);
    set('paths', $info['paths']);
    
    
    set('tables', $tables);
    
    return html('subapi.html.php');
}

function page_api_wrapper($info) {
    return json($info['handler']());
}
