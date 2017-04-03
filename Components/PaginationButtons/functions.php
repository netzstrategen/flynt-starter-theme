<?php

namespace Flynt\Components\PaginationButtons;

use Flynt\Features\Components\Component;
use Timber\Timber;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('PaginationButtons');
});

add_filter('Flynt/addComponentData?name=PaginationButtons', function ($data) {
    $queries = getQueries();
    if ($queries) {
        $args = [
        'post_type' => 'post'
        ];
        $args = array_merge($args, $queries);
        $args['paged'] = get_query_var('paged', 1);
        query_posts($args);
        $data['pagination'] = Timber::get_pagination();
    } else {
        $data['pagination'] = Timber::get_pagination();
    }
    return $data;
});

function getQueries()
{
    $queries = [];
    if (isset($_GET['category'])) {
        $queries['category_name'] = $_GET['category'];
    }

    if (isset($_GET['filtertag'])) {
        $queries['tag'] = $_GET['filtertag'];
    }

    if (count($queries) === 0) {
        $queries = false;
    }

    return $queries;
}