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

$GLOBALS['THE_API']['cr'] = [
    'title' => 'Kraje a města České republiky',
    'paths' => [
        [
            'path' => 'mesta',
            'description' => 'Seznam měst',
            'example' => 'mesta',
            'handler' => function() {
                return db_find_objects('vsechna mesta',
                    'SELECT id, jmeno FROM mesto'
                );
            },
        ],

        [
            'path' => 'mesta/:id',
            'params' => [ 'id' ],
            'description' => 'Detail města s daným ID',
            'example' => 'mesta/2',
            'handler' => function() {
                $id = params('id');
                $data = db_find_object('detail mesta',
                    'SELECT * FROM mesto WHERE id = :id',
                    [ 'id' => $id ]
                );

                if ($data == null) {
                    object_not_found(sprintf('Mesto %d neexistuje.', $id));
                }

                return $data;
            },
        ],

        [
            'path' => 'kraje',
            'description' => 'Seznam krajů',
            'example' => 'kraje',
            'handler' => function() {
                return db_find_objects('vsechny kraje',
                    'SELECT id, jmeno FROM kraj'
                );
            },
        ],

        [
            'path' => 'kraje/:id',
            'params' => [ 'id' ],
            'description' => 'Detail kraje s daným ID',
            'example' => 'kraje/3',
            'handler' => function () {
                $id = params('id');
                $data = db_find_object('detail kraje',
                    'SELECT * FROM kraj WHERE id = :id',
                    [ 'id' => $id ]
                    );

                if ($data == null) {
                    object_not_found(sprintf('Kraj %d neexistuje.', $id));
                }

                $mesta = db_find_objects('mesta v kraji',
                    'SELECT id FROM mesto WHERE kraj = :id',
                    [ 'id' => $id ]
                );
                $data['mesta'] = array_map(function($x) {
                    return $x['id'];
                }, $mesta);

                return $data;
            },
        ],
    ],


    'tables' => [
        [
            'title' => 'Města',
            'sql' => 'SELECT * FROM mesto ORDER BY jmeno'
        ],
        [
            'title' => 'Kraje',
            'sql' => 'SELECT * FROM kraj ORDER BY jmeno'
        ],
    ]
];
