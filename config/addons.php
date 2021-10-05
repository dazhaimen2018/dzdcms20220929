<?php

return array (
    'autoload' => false,
    'hooks' =>
        array (
            'text_translator' =>
                array (
                    0 => '\\addons\\translator\\Translator',
                ),
            'markdown' =>
                array (
                    0 => '\\addons\\editormd\\Editormd',
                ),
            'content_delete_end' =>
                array (
                    0 => '\\app\\member\\behavior\\Hooks',
                ),
            'content_edit_end' =>
                array (
                    0 => '\\app\\member\\behavior\\Hooks',
                ),
            'user_sidenav_after' =>
                array (
                    0 => '\\app\\cms\\behavior\\Hooks',
                ),
            'app_init' =>
                array (
                    0 => '\\app\\cms\\behavior\\Hooks',
                ),
        ),
    'route' =>
        array (
        ),
);