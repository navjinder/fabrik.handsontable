<?php
/**
 * Plugin element to render mootools slider
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.element.slider
 * @copyright   Copyright (C) 2005-2013 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

require_once JPATH_SITE . '/components/com_fabrik/models/element.php';

//$document = JFactory::getDocument();
// $document->addScript(JURI::base() .'plugins/fabrik_element/handsontable/handsontable.js');
// $document->addScript(JURI::base() .'../plugins/fabrik_element/handsontable/handsontable.js');
/**
 * Plugin element to render mootools slider
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.element.slider
 * @since       3.0
 */

class PlgFabrik_ElementHandsontable extends PlgFabrik_Element
{
	/**
	 * If the element 'Include in search all' option is set to 'default' then this states if the
	 * element should be ignored from search all.
	 * @var bool  True, ignore in extended search all.
	 */
	protected $ignoreSearchAllDefault = true;

	/**
	 * Db table field type
	 *
	 * @var string
	 */
	protected $fieldDesc = 'TEXT';

	/**
	 * Db table field size
	 *
	 * @var string
	 */
	//protected $fieldSize = '6';

	/**
	 * Draws the html form element
	 *
	 * @param   array  $data           To pre-populate element with
	 * @param   int    $repeatCounter  Repeat group counter
	 *
	 * @return  string	elements html
	 */

	public function render($data, $repeatCounter = 0)
	{
			FabrikHelperHTML::stylesheet(COM_FABRIK_LIVESITE . 'plugins/fabrik_element/handsontable/handsontable.css');
			//FabrikHelperHTML::addScriptDeclaration('requirejs(["' . COM_FABRIK_LIVESITE . 'plugins/fabrik_element/handsontable/handsontable.js"], function () {});');
			//$srcs = FabrikHelperHTML::framework();
			//$srcs[]	= 'plugins/fabrik_element/handsontable/handsontable.js';
			//$js .= $model->getPluginJsObjects();
			//$js .= $model->getFilterJs();
			//FabrikHelperHTML::script($srcs, $js);
			
			
		
		$name = $this->getHTMLName($repeatCounter);
		$id = $this->getHTMLId($repeatCounter);
		$params = $this->getParams();
		//$default = (string) $params->get('default');
		$hrows = (int) $params->get('h-rows',5);
		$hcols = (int) $params->get('h-cols', 5);
		$columns = (string) $params->get('columns');
		$colheaddata = (string) $params->get('col-head-data');
		$minsrows = (int) $params->get('mins-rows', 1);
		$minscols = (int) $params->get('mins-cols', 0);
		$colhead = (string) $params->get('col-head', "true");
		$rowhead = (string) $params->get('row-head', "false");
		$conmenu = (string) $params->get('con-menu', "true");
		$colsort = (string) $params->get('col-sort', "false");
		$colmove = (string) $params->get('col-move', "false");
		$colresize = (string) $params->get('col-resize', "false");
		$element = $this->getElement();
		$val = $this->getValue($data, $repeatCounter);
		$options = $this->getElementJSOptions($repeatCounter);
		$default = $options->defaultVal;
		$noteditable=0;
		
		if (!$this->isEditable())
		{
			//return $val;
			$noteditable= 1;
			
		}
		
		$str = array();
		//$str[] = '<script src="' . COM_FABRIK_LIVESITE  .'media/com_fabrik/js/element.js"></script>';
		$str[] = '<script src="' . COM_FABRIK_LIVESITE  .'plugins/fabrik_element/handsontable/handsontable.js"></script>';
		if(($colsort == "true")|| ($colmove == "true")||($colresize == "true")){$str[] = '<a class="reset-state btn btn-small" href="javascript:none;"> <span class="icon-refresh"></span> Reset</a>';}
		$str[] = '<div id="hand' . $id . '" class="fabrikSubElementContainer">';
		//FabrikHelperHTML::addPath(COM_FABRIK_BASE . 'plugins/fabrik_element/slider/images/', 'image', 'form', false);

		
		if(!$val){
		
				if($default){ 
				
				$val = $default;
				
				}
				
				else{
				$stringoutside= "";
				$stringinside = "" ;
				
						
						
		
								
								for($j=1;$j<$hcols;$j++){
								
								$stringinside = $stringinside . "\"\",";
								
								} 
						
						$stringoutside = $stringoutside . "[" . $stringinside . "\"\"],";
						
						
						$stringwhole = "[" . substr($stringoutside,0,-1) . "]"; 
						
						$val = 	$stringwhole;
		
				 }
			}
		
		elseif ($val) { $val = print_r($val, TRUE); }
		
		if(!$columns){ $columns = "["; for($k=1;$k<$hcols;$k++)  { $columns .= "&#123; &#125;,"; } $columns .= "&#123; &#125;]"; $columns = html_entity_decode($columns);}
		if(($colhead == "true") && ($colheaddata)){ $colhead = $colheaddata;}
		//$str[] = '<pre>'.print_r($options).'</pre>';
		$valueprinted = $val;
		$str[] = '<script>';
		$str[] = '  var data' . $id . '=' . $valueprinted . ';';
		$str[] = 'jQuery("#hand' . $id . '").handsontable({';
		if($noteditable == 1){$str[] = 'readOnly: true,';}
		$str[] = 'data:data' . $id .',';
		$str[] = 'startRows: ' . $hrows . ',';
		$str[] = 'startCols: ' . $hcols . ',';
		$str[] = 'colHeaders: ' . $colhead . ',';
		$str[] = 'rowHeaders: ' . $rowhead . ',';
		$str[] = 'minSpareRows: ' . $minsrows . ',';
		$str[] = 'minSpareCols: ' . $minscols . ',';
		$str[] = 'contextMenu: ' . $conmenu . ',';
		$str[] = 'columnSorting: ' . $colsort . ',';
		$str[] = 'manualColumnMove: ' . $colmove . ',';
		$str[] = 'manualColumnResize: ' . $colresize . ',';
		$str[] = 'columns: ' . $columns . ',';
		$str[] = 'persistentState: true ,';
		$str[] = 'afterChange: function(){';
		//$str[] = 'console.log("Updating Text area save' . $id . '");';
		//$str[] = 'var printthis = jQuery("#hand' . $id . '").handsontable("getData");';
		//$str[] = 'console.log(printthis);';
		$str[] = 'var tmpData' .$id. ' = jQuery.extend(true, [], data' . $id . ');';
		//$str[] = 'var tmpData2' .$id. ' = JSON.stringify(tmpData' . $id . ').replace(/\'/g,"&quot;").replace(/(\"d+\")/g, \'$1\');';
		$str[] = 'var tmpData2' .$id. ' = JSON.stringify(tmpData' . $id . ');';
		$str[] = 'jQuery("#save' . $id .'").val(tmpData2' .$id. ');';
		$str[] = '},';
		$str[] = '});';
		$str[] = 'var this' . $id . ' = jQuery("#' . $id . '").handsontable("getInstance");';
		$str[] = 'jQuery(".reset-state").on("click", function(){this' . $id . '.PluginHooks.run("persistentStateReset");this' . $id . '.updateSettings({ columnSorting: ' . $colsort . ',manualColumnMove:' . $colmove . ',manualColumnResize: ' . $colresize . '  }); });';
		$str[] = '</script>';
		//$val2 = str_replace('\'','\\\\\'',$val);
		//$str[] = '<input type="hidden" id="save' .$id. '" class="fabrikinput" name="' . $name . '" value=\'' . str_replace("&quot;", "`",$val) . '\' />';
		$str[] = '<textarea style="display:none" rows="10" cols="10" id="save' .$id. '" name="' . $name . '">' . $valueprinted . '</textarea>';
		$str[] = '</div>';

		return implode("\n", $str);
	}
	
	/**
	 * Shows the data formatted for the list view
	 *
	 * @param   string    $data      elements data
	 * @param   stdClass  &$thisRow  all the data in the lists current row
	 *
	 * @return  string	formatted value
	 */

	public function renderListData($data, stdClass &$thisRow)
	{
		unset($this->default);
		$value = $this->getValue(JArrayHelper::fromObject($thisRow));
		return parent::renderListData(JText::_('PLG_ELEMENT_HANDSONTABLE_DETAIL_MESSG'), $thisRow);
	}


	/**
	 * Manipulates posted form data for insertion into database
	 *
	 * @param   mixed  $val   This elements posted form data
	 * @param   array  $data  Posted form data
	 *
	 * @return  mixed
	 */

	public function storeDatabaseFormat($val, $data)
	{
		// If clear button pressed then store as null.
		if ($val == '')
		{
			$val = null;
		}

		return $val;
	}

	/**
	 * Returns javascript which creates an instance of the class defined in formJavascriptClass()
	 *
	 * @param   int  $repeatCounter  Repeat group counter
	 *
	 * @return  array
	 */

	 public function elementJavascript($repeatCounter)
	{
		$params = $this->getParams();
		$id = $this->getHTMLId($repeatCounter);
		$opts = $this->getElementJSOptions($repeatCounter);
		//$opts->steps = (int) $params->get('slider-steps', 100);
		$data = $this->getFormModel()->data;
		$opts->value = $this->getValue($data, $repeatCounter);

		return array('FbHansontable1', $id, $opts);
	} 
}
