<?php


namespace App\Traits;


trait CSVHelper
{
    public function csv_to_array($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    public function extractLinks($objects){
        $links = [];
        foreach ($objects as $object){
            $source = $object['Line Source'];
            $destination = $object['Line Destination'];
            if (!($source == '') and !($destination == '')){
                $sourceArrow = $object['Source Arrow'];
                $destinationArrow = $object['Destination Arrow'];
                array_push($links, [$source, $destination, $sourceArrow, $destinationArrow]);
            }
        }
        return $links;
    }

    public function extractChildrenObjects($objects){
        $childObjects = [];
        foreach ($objects as $object){
            if ($object['Contained By'] != ''){
                array_push($childObjects, $object['Id']);
            }
        }
        return $childObjects;
    }

    public function extractParentObjects($objects){
        $parentObjects = [];
        foreach ($objects as $object){
            if ($object['Contained By'] != ''){
                $parentObjectsForObject = mb_split(',', str_replace('|', ',', $object['Contained By']));
                foreach ($parentObjectsForObject as $value){
                    if (!in_array($value, $parentObjects)){
                        array_push($parentObjects, $value);
                    }
                }
            }
        }
        return $parentObjects;
    }

    public function extractParentsWithChildren($objects){
        $parentsWithChildren = [];
        $parentObjectIds = $this->extractParentObjects($objects);

        foreach ($parentObjectIds as $parentObjectId){ // For Every Parent Object ID
            $childrenObjects = [];
            foreach ($objects as $object) { // For Every Object in given Objects
                if ($object['Contained By'] != ''){ // If the Object is Contained By another Object
                    $parentsOfObject = mb_split(',', str_replace('|', ',', $object['Contained By'])); // Split the containing Object Ids into an array
                    foreach ($parentsOfObject as $parentObjectId){
                        if ($parentObjectId == $parentObjectId){
                            array_push($childrenObjects, $object['Id']);
                        }
                    }
                }
            }

            array_push($parentsWithChildren, [
                $parentObjectId => array_unique($childrenObjects)
            ]);
        }

        dd($parentsWithChildren);

        return $parentsWithChildren;
    }
}
