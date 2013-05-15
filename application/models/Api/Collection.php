<?php
/**
 * Omeka
 * 
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * @package Omeka\Record\Api
 */

class Api_Collection extends Omeka_Record_Api_AbstractRecordAdapter
{
    /**
     * Get the REST API representation for Collection
     * 
     * @param Collection $record 
     * @return array 
     */
    public function getRepresentation(Omeka_Record_AbstractRecord $record) {
        $representation = array();
        $representation['id'] = $record->id;
        $representation['url'] = $this->getResourceUrl("/collections/{$record->id}");
        $representation['owner'] = array(
            'id'  => $record->owner_id,
            'url' => $this->getResourceUrl("/users/{$record->owner_id}"),
        );
        $representation['public'] = (bool) $record->public;
        $representation['featured'] = (bool) $record->featured;
        $representation['added'] = $this->getDate($record->added);
        $representation['modified'] = $this->getDate($record->modified);
        $representation['items'] = array(
            'count' => $record->getTable('Item')
                ->count(array('item_id' => $record->id)),
            'url' => $this->getResourceUrl("/items?collection={$record->id}"),
        );
        $representation['element_texts'] = $this->getElementTextRepresentations($record);
        
        return $representation;
    }
    
    /**
     * Set data to a Collection.
     * 
     * @param Collection $data
     * @param mixed $data
     */
    public function setData(Omeka_Record_AbstractRecord $record, $data)
    {
        
    }
}
