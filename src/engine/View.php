<?php

class View {
	protected $id;
	protected $name;
	
	protected $styles;
	protected $scripts;
	
	protected $Modules;
	
	function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function createView() {
		$a = func_get_args();
        $i = func_num_args();
		
		header('Content-type: text/html; charset=UTF-8');
		$this->Modules = DB::getPageModules($this->id);
		if($Modules === 1) {
			/// Extraction error
		} else if($Modules === 2){
			/// No modules
		} else {
			$this->styles = $this->Modules->getStyles();
			$this->scripts = $this->Modules->getScripts();
			foreach($this->Modules as $Module) {
				$template = $Module->getTemplate();
				$position = $Module->getPosition();
				$this->addModuleWidth($Module);
				$Module->addParam('page_name', $this->name);
				Flight::render('modules/' . $template, $Module->getParams(), $position->getPosition());
			}
		}
		Flight::render('template.html', array('styles' => $this->generateStyles($this->styles), 'scripts' => $this->generateScripts($this->scripts), 'page_name' => $this->name));
	}

	private function addModuleWidth(&$Module) {
		$width = 12;
		$position = $Module->getPosition();
		$num = $this->Modules->getModulesNumInBlock($position->getBlock());
		if($num >= $position->getMaxItems()) {
			$width = $width / 4;
		} else {
			$width = $width / $num;
		}
		$Module->addParam('width', $width);
	}
	
	private function generateStyles($styles) {
		$generatedStyles = "";
		if(!empty($styles) && $styles != null) {
			foreach($styles as $style) {
				if($style != '') {
					$generatedStyles .= '<link href="style/css/' . $style . '.css" type="text/css" rel="stylesheet" media="screen,projection"/>';
				}
			}
		}
		return $generatedStyles;
	}

	private function generateScripts($scripts) {
		$generatedScripts = "";
		if(!empty($scripts) && $scripts != null) {
			foreach($scripts as $script) {
				if($script != '') {
					$generatedScripts .= '<script src="' . Flight::get('flight.base_url') . 'style/js/' . $script . '.js"></script>';
				}
			}
		}
		return $generatedScripts;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
}
