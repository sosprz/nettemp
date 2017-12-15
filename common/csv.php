<?php
ob_clean();
ob_start();

$action = isset($_POST['action']) ? $_POST['action'] : '';
$file = isset($_POST['file']) ? $_POST['file'] : '';
$daterange = isset($_POST['daterange']) ? $_POST['daterange'] : '';
$pieces = explode(" ", $daterange);
$start=$pieces[0]." ".$pieces[1];
$end=$pieces[3]." ".$pieces[4];


// Set headers to make the browser download the results as a csv file
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$file.csv");
header("Pragma: no-cache");
header("Expires: 0");


// Connect to DB
$conn = new PDO("sqlite:db/$file.sql");

// Query

if($action=='get') {
	$query = $conn->query("SELECT * FROM def");
}
elseif($action=='getc') {
	$query = $conn->query("SELECT * FROM def WHERE time BETWEEN '$start' AND '$end'");
}

// Fetch the first row
$row = $query->fetch(PDO::FETCH_ASSOC);

// If no results are found, echo a message and stop
if ($row == false){
    echo "No results";
    exit;
}

// Print the titles using the first line
print_titles($row);
// Iterate over the results and print each one in a line
while ($row != false) {
    // Print the line
  echo implode(array_values($row), ",") . "\n";
    // Fetch the next line
  $row = $query->fetch(PDO::FETCH_ASSOC);
}

// Prints the column names
function print_titles($row){
    echo implode(array_keys($row), ",") . "\n";
}
exit();
?>