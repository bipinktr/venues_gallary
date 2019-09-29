<?php

namespace App\Models;

class Venue
{
    private $data = array();

    public function __construct()
    {
        $dataSource = config('app.default_data_source');
        if ($dataSource == 'xml') {
            $this->data = $this->parseXML();
        } else {
            $this->data = $this->parseJSON();
        }
    }

    private function parseJSON()
    {
        $json = file_get_contents(base_path() . '/../data/venues.json');
        return json_decode($json, true);
    }

    private function parseXML()
    {
        $xml = simplexml_load_file(base_path() . '/../data/venues.xml');
        $json = json_encode($xml);
        if ($xml->count() == 1) {
            return array_values(json_decode($json, true));
        }
        return json_decode($json, true)['venue'];
    }

    public function getVenues()
    {
        return $this->data;
    }
}
