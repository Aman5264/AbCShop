<?php
// PHP Script to dump SQLite tables into MySQL-compatible INSERT statements
// Run this locally: php export_for_mysql.php

$databasePath = __DIR__ . '/database/database.sqlite';
if (!file_exists($databasePath)) {
    die("Error: SQLite database not found at $databasePath\n");
}

try {
    $db = new PDO('sqlite:' . $databasePath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Complete list of tables to migrate
    $tables = [
        'users',
        'roles',
        'permissions',
        'model_has_roles',
        'model_has_permissions',
        'role_has_permissions',
        'categories',
        'products',
        'pages',
        'blog_categories',
        'blog_posts',
        'blog_tags',
        'blog_post_blog_tag',
        'blog_comments',
        'faq_categories',
        'faqs',
        'banners',
        'settings',
        'wishlists',
        'reviews',
        'addresses',
        'coupons',
        'newsletter_subscribers',
        'refund_requests'
    ];

    $outputFile = 'mysql_dump.sql';
    $handle = fopen($outputFile, 'w');
    
    fwrite($handle, "-- ABC Shop Data Export\n");
    fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");

    foreach ($tables as $table) {
        try {
            echo "Processing table: $table...\n";
            $stmt = $db->query("SELECT * FROM $table");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($rows)) {
                echo "  Table $table is empty, skipping.\n";
                continue;
            }

            fwrite($handle, "-- Data for $table\n");
            foreach ($rows as $row) {
                $keys = array_keys($row);
                $values = array_map(function($v) use ($db) {
                    if ($v === null) return 'NULL';
                    // Manual escape for simple cases, PDO quote handles basic strings
                    return $db->quote($v);
                }, array_values($row));
                
                $sql = "INSERT INTO `$table` (`" . implode('`, `', $keys) . "`) VALUES (" . implode(', ', $values) . ");\n";
                fwrite($handle, $sql);
            }
            fwrite($handle, "\n");
        } catch (Exception $e) {
            echo "  Error processing table $table: " . $e->getMessage() . "\n";
        }
    }

    fwrite($handle, "\nSET FOREIGN_KEY_CHECKS = 1;\n");
    fclose($handle);
    echo "\nSuccess! Your data has been exported to: $outputFile\n";
    echo "You can now copy the contents of this file into your Railway MySQL console.\n";

} catch (Exception $e) {
    die("Connection Error: " . $e->getMessage() . "\n");
}
