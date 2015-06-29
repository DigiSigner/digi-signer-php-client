<?php

namespace DigiSigner;

abstract class ExportObject {
	
	/**
	 * properties, that will be exported to plain object after $this->export() call
	 * will be used for future serialization to JSON
	 */
	
	//TODO create abstract method instead
	protected $exportProps = array();
	
	/**
	 * The function recursively export the object into plain stdClass object which then can be used
	 * for JSON serialization
	 * @return stdClass - standard object, populated with properties that should be serialized to JSON
	 * The properties should have been declared in $this->exportProps array of each descending class.
	 * 
	 */
	public function export() {
		
		if(empty($this->exportProps)) {
			throw new DigiSignerException('Property $exportProperties must be specified for '. get_called_class() .' class');
		}
		
		$export = new \stdClass;
		foreach($this->exportProps as $prop) {
			if(property_exists($this, $prop) && !is_null($this->$prop)) {
				
				if(is_array($this->$prop)) {
					foreach($this->$prop as $key => $item) {
						if(is_a($item, __CLASS__)) {
							$export->{$prop}[$key] = $item->export();
						} else {
							$export->{$prop}[$key] = $item;	
						}	
					}
					
				} else {
					$export->$prop = $this->$prop;
				}
			}
			
		}
		return $export;
	}
	
	public function toJSON($pretty = false) {
			
		if($pretty) $pretty = JSON_PRETTY_PRINT;
		$data = $this->export();
		
		return json_encode($data, $pretty);
	}
	
	public function fromObject($plainObject) {
		foreach($plainObject as $property => $value) {
			
			/** policy has chaged, now we import everything
			if(!property_exists($this, $property)) {
				throw new DigiSignerException("Property '$property' must exist in ".get_called_class(). " and be writable by parent class (protected) for proper import.");
			}
			*/
			
			if($this->hasCollection($property) && is_array($value)) {
				
				$fullClassName = __NAMESPACE__ .'\\'. $this->getCollectionClass($property);

				//clear the collection
				$this->{$property} = array();
				
				//and import collection residing in $value recursively from stdClass object, reflecting the JSON data received
				foreach($value as $object) {
					$collectionItem = new $fullClassName;
			
					if(is_a($collectionItem, __CLASS__)) {
						$this->{$property}[] = $collectionItem->fromObject($object);
					}
				}
				
			} else {
				$this->$property = $value;
			}
		}
		
		return $this;
	}
	
	public function hasCollection($property) {
		return array_key_exists($property, $this->getCollectionsMap());
	}
	
	public function getCollectionClass($property) {
		$collections = $this->getCollectionsMap();
		return $collections[$property];
	}
	
	public function parseJSON($json) {
		return json_decode($json);
	}
	
	/**
	 * @return Array Associated array('collectionPropertyName' => 'entityClassName'),
	 * eg. array('documents' => 'Document');
	 * or empty Array array() if the object holds no collections
	 */
	abstract protected function getCollectionsMap();
}
