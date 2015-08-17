<?php

class Ps2_Upload {
	
	protected $_uploaded = array();
	protected $_destination;
	protected $_max = 51200;
	protected $_messages = array();
	protected $_permitted = array('image/gif',
								  'image/jpeg',
								  'image/pjpeg',
								  'image/png',
								  'audio/mp3',
								  'video/mpeg',
								  'video/avi',
								  'video/mpg',
								  'video/mpe',
								  'video/qt',
								  'video/mov',
								  'video/mp4',
								  'video/quicktime'
								  );
	protected $_renamed = false;
	protected $_getfilename;
	
	public function __construct($path) {
		if (!is_dir($path) || !is_writable($path)) {
			throw new Exception("$path must be a valid, writable directory.");	
		}
		$this->_destination = $path;
		$this->_uploaded = $_FILES;
	}
	
	public function move($overwrite = false) {
		$field = current($this->_uploaded);
		$OK = $this->checkError($field['name'], $field['error']);
		if ($OK) {
			$sizeOK = $this->checkSize($field['name'], $field['size']);
			$typeOK = $this->checkType($field['name'], $field['type']);
			if ($sizeOK && $typeOK) {
				$name = $this->checkName($field['name'], $overwrite);
				$success = move_uploaded_file($field['tmp_name'], $this->_destination . $name);
				if ($success) {
					$message = $field['name'] . ' uploaded successfully';	
					$this->_getfilename = $name;
					if ($this->_renamed) {
						$message .= " and renamed $name";
						$this->_getfilename = $name;
					}
					$this->_messages[] = $message;
				} else {
					$this->_messages[] = 'Could not upload ' . $field['name'];	
				}
			}
		}
	}
	
	public function getMessages() {
		return $this->_messages;	
	}
	public function getFileName() {
		return $this->_getfilename;	
	}
	protected function checkError($filename, $error) {
		switch ($error) {
			case 0:
				return true;
			case 1:
			case 2:
				$this->_messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
				return true;
			case 3:
				$this->_messages[] = "Error uploading $filename. Please try again.";
				return false;
			case 4: 
				$this->_messages[] = 'No file selected.';
				return false;
			default:
				$this->_messages[] = "System error uploading $filename. Contact webmaster.";
				return false;
		}
	}
	
	protected function checkSize($filename, $size) {
		if ($size == 0) {
			return false;	
		} elseif ($size > $this->_max) {
			$this->_messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
			return false;	
		} else {
			return true;	
		}
	}
	
	protected function checkType($filename, $type) {
		if (empty($type)) {
			return false;
		} elseif (!in_array($type, $this->_permitted)) {
			$this->_messages[] = "$filename is not a permitted type of file.";
			return false;	
		} else {
			return true;	
		}
	}
	
	public function getMaxSize() {
		return number_format($this->_max/1024, 1) . 'kB';	
	}
	
	public function addPermittedTypes($types) {
		$types = (array) $types;
		$this->isValidMime($types);
		$this->_permitted = array_merge($this->_permitted, $types);	
	}
	
	public function setPermittedTypes($types) {
		$types = (array) $types;
		$this->isValidMime($types);
		$this->_permitted = $types;	
	}
	
	protected function isValidMime($types) {
		$alsoValid = array('image/tiff',
						   'application/pdf',
						   'text/plain',
						   'text/rtf');
		$valid = array_merge($this->_permitted, $alsoValid);
		foreach ($types as $type) {
			if (!in_array($type, $valid)) {
				throw new Exception("$type is not a permitted MIME type");	
			}
		}
	}
	
	public function setMaxSize($num) {
		if (!is_numeric($num)) {
			throw new Exception("Maximum size must be a number.");	
		}
		$this->_max = (int) $num;
	}
	
	protected function checkName($name, $overwrite) {
		$nospaces = str_replace(' ', '_', $name);
		if ($nospaces != $name) {
			$this->_renamed = true;	
		}
		if (!$overwrite) {
			//rename the file if it already exists
			$existing = scandir($this->_destination);
			if (in_array($nospaces, $existing)) {
				$dot = strrpos($nospaces, '.');
				if ($dot) {
					$base = substr($nospaces, 0, $dot);
					$extension = substr($nospaces, $dot);	
			} else {
				$base = $nospaces;
				$extension = '';	
			}
			$i = 1;
			do {
				$nospaces = $base . '_' . $i++ . $extension;	
			} while (in_array($nospaces, $existing));
			$this->_renamed = true;
			}
		}
		return $nospaces;
	}
}