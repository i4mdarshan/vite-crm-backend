<?php
// Check for the required command-line arguments
if ($argc < 2) {
    echo "Usage: php database_tools.php <action> [options]\n";
    echo "Actions:\n";
    echo "  backup - Backup the MySQL database\n";
    echo "  schema - Generate table schema of the MySQL database\n";
    echo "  reset_db - Truncate all the tables except system tables of the MySQL database\n";
    exit(1);
}

$action = $argv[1];

// Set your MySQL database credentials
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'crm_web_app_laravel_2';

// Function to backup the MySQL database
function backupDatabase($host, $username, $password, $database)
{
    // Generate a unique filename for the backup
    $backupFilename = 'backup_' . date('Ymd_His') . '.sql';

    // Construct the mysqldump command
    $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} > {$backupFilename}";

    // Execute the command
    exec($command, $output, $returnCode);

    if ($returnCode === 0) {
        echo "Database backup completed successfully. Backup file: {$backupFilename}\n";
    } else {
        echo "Error during database backup: " . implode("\n", $output) . "\n";
    }
}

//Function to generate db table structure with no data other than the systemdata
function resetDB($host, $username, $password, $database)
{
    echo "Working on database: {$database}\n";

    // Backup sql file before reset
    // Generate a unique filename for the backup
    $backupFilename = 'backup_' . date('Ymd_His') . '.sql';

    // Construct the mysqldump command
    $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} > {$backupFilename}";

    // Execute the command
    exec($command, $output, $returnCode);

    if ($returnCode === 0) {
        echo "Database backup completed successfully. Backup file: {$backupFilename}\n";
    } else {
        echo "Error during database backup: " . implode("\n", $output) . "\n";
    }
    
    // Create a database connection
    $mysqli = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // List of tables to exclude from truncation
    $tablesToExclude = array('users','firms','roles','modules','modules_roles','product_units','product_details','product_category','user_details','user_roles','state','complaint_statuses');
    
    // Create a database connection
    $mysqli = new mysqli($host, $username, $password, $database);
    
    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get a list of all tables in the database
    $query = "SHOW TABLES";
    $result = $mysqli->query($query);
    
    if ($result) {
        // Disable foreign key checks temporarily
        $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
        
        while ($row = $result->fetch_assoc()) {
            $tableName = $row['Tables_in_' . $database];
                
            // Check if the table should be excluded from truncation
            if (!in_array($tableName, $tablesToExclude)) {
                // Generate SQL statements to truncate tables
                $truncateQuery = "TRUNCATE TABLE `{$tableName}`";
                if ($mysqli->query($truncateQuery)) {
                    echo "Table '{$tableName}' truncated successfully.\n";
                } else {
                    echo "Error truncating table '{$tableName}': " . $mysqli->error . "\n";
                }
            }
        }
        // Re-enable foreign key checks
        $mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
        // Close the result set
        $result->free();
    } else {
        echo "Error listing tables: " . $mysqli->error . "\n";
    }
    
    // Close the database connection
    $mysqli->close();
}

// Function to generate a table schema of the MySQL database
function generateTableSchema($host, $username, $password, $database)
{
    // Connect to the MySQL database
    $connection = mysqli_connect($host, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get a list of tables in the database
    $tables = array();
    $query = "SHOW TABLES";
    $result = mysqli_query($connection, $query);

    if ($result) {
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        // Generate table schemas
        foreach ($tables as $table) {
            $query = "SHOW CREATE TABLE {$table}";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "Table schema for {$table}:\n{$row['Create Table']}\n";
            }
        }

        // Close the database connection
        mysqli_close($connection);
    } else {
        echo "Error: " . mysqli_error($connection) . "\n";
    }
}

// Perform the selected action
if ($action === 'backup') {
    backupDatabase($host, $username, $password, $database);
} elseif ($action === 'schema') {
    generateTableSchema($host, $username, $password, $database);
} elseif ($action === 'reset_db') {
    resetDB($host, $username, $password, $database);
}else {
    echo "Invalid action. Use 'backup' 'reset_db' or 'schema'.\n";
    exit(1);
}
