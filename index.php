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

/*
 * Central script for our application.
 * 
 * We include Limonade and our scripts, set-up and run the application.
 */

require_once 'lib/limonade.php';
require_once 'lib/inc.php';

$GLOBALS['THE_API'] = [];
require_once_dir('apis/');

function configure() {
	db_init('sqlite:db/db.sqlite');
}

session_start();

header("Access-Control-Allow-Origin: *");

layout('layout/empty.php');

function not_found($errno, $errstr, $errfile=null, $errline=null) {
    return $errstr;
}

dispatch('/', 'page_index', ['params' => [ $GLOBALS['THE_API'] ]]);

foreach ($GLOBALS['THE_API'] as $base => $info) {
    dispatch('/' . $base, 'page_api_overview', ['params' => [ $base, $info ]]);
    foreach ($info['paths'] as $path) {
        dispatch('/' . $base . '/' . $path['path'], 'page_api_wrapper', ['params' => [ $path ] ]);
    }
}

run();
