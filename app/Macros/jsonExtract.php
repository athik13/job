<?php


/*
 * MySQL 5.7 | MariaDB 10.2.3 and later supports the JSON manipulation methods
 * (JSON_EXTRACT, JSON_UNQUOTE, ...)
 *
 * MySQL 5.7.9 and later supports the -> operator
 * - JSON_EXTRACT(c, "$.id") becomes c->"$.id"
 *
 * MySQL 5.7.13 and later supports the ->> operator
 * - JSON_UNQUOTE(JSON_EXTRACT(column, path)) becomes JSON_UNQUOTE(column->path)
 * - JSON_UNQUOTE(column->path) becomes column->>path
 */

if (!function_exists('jsonExtract')) {
    /**
     * @param string $column
     * @param string $path
     * @return string
     */
    function jsonExtract(string $column, string $path): string
    {
        // Convert non-JSON value column to the right JSON format
        $jsonObjColumn = 'JSON_OBJECT(\'' . $path . '\', ' . $column . ')';
        $isValidJson = 'JSON_VALID(' . $column . ')';
        $column = 'IF(' . $isValidJson . ', ' . $column . ', ' . $jsonObjColumn . ')';

        $path = (starts_with($path, '[')) ? '$' . $path : '$.' . $path;

        // Apply WHERE clause using MySQL JSON methods
        // $jsonColumn = $column . '->>"' . $path . '"'; // MySQL 5.7.13
        $jsonColumn = 'JSON_UNQUOTE(JSON_EXTRACT(' . $column . ', \'' . $path . '\'))';

        return $jsonColumn;
    }
}
