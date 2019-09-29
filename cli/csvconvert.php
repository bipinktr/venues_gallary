<?php
if ($argc > 1) {
    $csvData = $headers = array();
    $i = 0;
    $csvFile = @fopen($argv[1], 'r');

    $doc = new DomDocument();
    $doc->formatOutput = true;

    $root = $doc->createElement('venues');
    $doc->appendChild($root);

    if ($csvFile) {
        $outputFile = realpath(__DIR__ . '/../data') . '/venues';
        while (($row = fgetcsv($csvFile)) !== false) {
            if (array(null) === $row) {
                continue;
            }
            if (empty($headers)) {
                $headers = $row;
                continue;
            }

            $child = $doc->createElement('venue');
            foreach ($row as $k => $column) {
                $value = sanitizeInput($column);
                $header = sanitizeInput($headers[$k]);
                $csvData[$i][$header] = $value;

                $tag = $doc->createElement($header);
                $child->appendChild($tag);
                $data = $doc->createTextNode($value);
                $tag->appendChild($data);
            }
            $root->appendChild($child);
            $i++;
        }
        fclose($csvFile);

        $xml = $doc->saveXML();
        $xmlFile = fopen($outputFile . '.xml', 'w');
        fwrite($xmlFile, $xml);
        fclose($xmlFile);

        $jsonFile = fopen($outputFile . '.json', 'w');
        fwrite($jsonFile, json_encode($csvData, JSON_PRETTY_PRINT));
        fclose($jsonFile);
        echo "Both json and xml files were generated.\nFiles are $outputFile.json and  $outputFile.xml\n";
    } else {
        echo "Please give a valid csv file as input\n";
    }

} else {
    echo "Please give the csv file as input\n";
}

function sanitizeInput($str)
{
    return trim(filter_var(str_replace("\xE2\x80\x8B", "", $str), FILTER_SANITIZE_STRING));
}