<?php

return [
    'hosts' => explode(',', env('ELASTICSEARCH_HOST')),
    'retries' => 1
];
