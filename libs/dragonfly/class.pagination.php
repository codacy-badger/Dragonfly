<?php

class Pagination
{

    private $params;

    /**
     * Constructor of Pagination
     *
     * @param $params
     */
    public function __construct($params) {
        $this->params = $params;
    }

    /**
     * Calculate total of pages
     *
     * @param $total_items
     * @param $items_per_page
     * @return float
     */
    private function calculateTotalPages($total_items, $items_per_page) {
        return round($total_items / $items_per_page, 0);
    }

    /**
     * Render pagination to html tags
     *
     * @return string
     */
    public function render() {
        extract($this->params);

        if (!isset($page)) {
            $page = 1;
        }

        if (!isset($items_per_page)) {
            $items_per_page = 10;
        }

        if (!isset($total_items)) {
            die('Total items is needed.');
        }

        $text = '<div class="pagination">';
        $text .= '<ul>';

        for ($i = 0; $i <= $this->calculateTotalPages($total_items, $items_per_page); $i++) {
            $isActive = ($page == ($i + 1));

            if ($isActive) {
                $a = '<a href="#">' . ($i + 1) . '</a>';
            } else {
                $a = '<a href="' . ensureNotEndsWith(full_url(false), '/') . '/?' . $this->rebuildURL("page", $i + 1) . '">' . ($i + 1) . '</a>';
            }

            $text .= '<li' . ($isActive ? ' class="active"' : '') . '>' . $a . '</li>';
        }

        $text .= '</ul>';
        $text .= '</div>';


        return $text;
    }

    /**
     * Recreate QueryString url
     *
     * @param $name
     * @param $value
     * @return string
     */
    private function rebuildURL($name, $value) {
        $params = $_GET;
        $params[$name] = $value;
        return http_build_query($params);
    }
}