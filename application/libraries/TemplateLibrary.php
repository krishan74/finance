<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(FCPATH . 'vendor/autoload.php');
require(FCPATH . 'externalLibrary/htmlToDoc/sourceCode/HTMLtoOpenXML.php');

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings as WordSettings;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007\Element\Container;
use PhpOffice\Common\XMLWriter;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use DocxMerge\DocxMerge;

class TemplateLibrary {
	
	private $fname;
	private $filename;
	private $fileCounter = 1;
	private $CI;
	private $tempImgFile;
	private $returnArray;
	private $templateProcessor;
	private $keyValue;
	private $loopKey;
	const sourcePath = FCPATH . "assets/templates/";
	const destinationPath = FCPATH . "assets/created-templates/";
	const scheduleAPath = FCPATH . "assets/temp-schedule-a/";

	public function __construct() {

		$this->CI = & get_instance();
		$this->CI->load->database();

	}

	public function saveTemplate($templateName, $replaceArray, $htmlData, $allDataJson, $CompanyIdJson, $CompanyNameJson, $uploadedFilename, $oldFileName) {

		if(empty($templateName) || empty($replaceArray)) {
			return false;
		}

		$source = self::sourcePath . $templateName;
		
		$this->fname = $this->CI->session->LoginId . '-' . date('YmdHis') . rand() . '-' . $templateName;  
		$this->filename = self::destinationPath . $this->fileCounter . $this->fname;
		$this->fileCounter++; 

		if(!file_exists($source)) {
			return false;
		}

		// Replacing Template Code...

		$templateArray = $this->generateTemplateCode($CompanyIdJson, $oldFileName);
		$clientCode = $templateArray['clientCode']; 
		$templateCode = $templateArray['templateCode'];
		$currentDate = $templateArray['currentDate'];
		$replaceArray['templateCode'] = $templateCode;					

		// Replacing Template Code...

		$this->templateProcessor = new TemplateProcessor($source);

		foreach($replaceArray as $key => $value) {

			// Replacing & sign with &amp;
			$value = str_replace("&", "&amp;", $value);
			// Replacing & sign with &amp;
			
			$this->templateProcessor->setValue($key, $value);
		}	

		$this->templateProcessor->saveAs($this->filename);

		// Replace Single Line Variables.

		if($uploadedFilename != "") {

			$scheduleAFilename = $this->saveTemplateScheduleA($uploadedFilename); // Merging Document.
			if(!$scheduleAFilename) { 
				return false;
			} 

		} elseif(!empty($htmlData)) {
			$scheduleAFilename = "";


			foreach($htmlData as $key => $value) {

				$value = trim($value);
				$value = $this->ulLi($value);
				$value = $this->olLi($value);
				$this->loopKey = $key;
				$this->returnArray = array();
				$diffElements = $this->fetchTable($value);

				$this->loopKey = $key;
				$this->keyValue = '<p>' . '${' . $key . '}' . '</p>';

				foreach($diffElements as $diffKey => $diffValue) {

					if(substr($diffValue, 0, 6) != '<table') {
						
						$this->templateProcessor = new TemplateProcessor($this->filename);	
							
						$phpWord = new PhpWord('Word2007');
						$section = $phpWord->addSection();
			
						$html = "<!DOCTYPE html><html><body>" . $diffValue . $this->keyValue . "</body></html>";
						
						Html::addHtml($section, $html, true, false);
						$writer = IOFactory::createWriter($phpWord, 'Word2007');

						$xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY, './', WordSettings::hasCompatibility());

						$containerWriter = new Container($xmlWriter, $section);
						$containerWriter->write();
						$tempXml = $xmlWriter->getData();
						$tempXml = str_replace("%space%", "    ", $tempXml);
						$htmlAsXml = $tempXml;

						WordSettings::setOutputEscapingEnabled(false);
						$this->templateProcessor->setValue($key, $htmlAsXml);
						WordSettings::setOutputEscapingEnabled(true);
						
						$this->saveWordFile();					

					} else {
						if(strpos($diffValue, 'imgCustomUnique') == False) {
							$this->templateProcessor = new TemplateProcessor($this->filename);
							
							$phpWord = new PhpWord('Word2007');
							$section = $phpWord->addSection();
													
							$noSpace = array('spaceBefore' => 100, 'spaceAfter' => 100);

							$fancyTableStyle = [
							    'borderSize'  => 6,
							    'borderColor' => 'A9A9A9',
							    'cellMargin'  => 20,
							    'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
							    'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_AUTO,
							];

							$table = $section->addTable($fancyTableStyle);
							
							$htmlContent = $diffValue;
							$DOM = new DOMDocument();
							$DOM->loadHTML($htmlContent);
							$rows = $DOM->getElementsByTagName('tr');
							

							foreach($rows as $row) {
								
								$cells = $row->getElementsByTagName('td');
								$table->addRow();
								$tempCount = 0;
								

								foreach ($cells as $cell) {
									$tempCount++;
								}

								foreach ($cells as $cell) {
									$cell = $table->addCell(5000)->addText($cell->nodeValue, null, $noSpace); 	
								}
							}

							$writer = IOFactory::createWriter($phpWord, 'Word2007');

							// convert the html to "word2017" xml
							$xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY, './', WordSettings::hasCompatibility());

							$containerWriter = new Container($xmlWriter, $section);
							$containerWriter->write();
							$searchXml = $xmlWriter->getData();

							$html = "<!DOCTYPE html><html><body>" . $this->keyValue . "</body></html>";
							
							$phpWordNew = new PhpWord('Word2007');
							$sectionNew = $phpWordNew->addSection();
							Html::addHtml($sectionNew, $html, true, false);
							$writer = IOFactory::createWriter($phpWordNew, 'Word2007');

							// convert the html to "word2017" xml
							$xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY, './', WordSettings::hasCompatibility());

							$containerWriter = new Container($xmlWriter, $sectionNew);
							$containerWriter->write();
							$xmlNew = $xmlWriter->getData();
							$htmlAsXml = $searchXml . $xmlNew;						
							$htmlAsXml = str_replace("%space%", "    ", $htmlAsXml);

							WordSettings::setOutputEscapingEnabled(false);
							$this->templateProcessor->setValue($key, $htmlAsXml);
							WordSettings::setOutputEscapingEnabled(true);
							
							$this->saveWordFile();		
						} else {

							$dom = new DOMDocument();
							$dom->loadHTML($diffValue);

							$xpath = new DOMXPath($dom); 
							$imgfind = $dom->getElementsByTagName('img');
							
							foreach($imgfind as $im)
							{
							  $src = $im->getAttribute('src');
							  break;
							}									
							
							if(!empty($src)) {
								$data = $src;
								if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
								    $data = substr($data, strpos($data, ',') + 1);
								    $type = strtolower($type[1]); // jpg, png, gif

								    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
								        throw new \Exception('invalid image type');
								    }
								    $data = str_replace( ' ', '+', $data );
								    $data = base64_decode($data);

								    if ($data === false) {
								        throw new \Exception('base64_decode failed');
								    }
								} else {
								    throw new \Exception('did not match data URI with image data');
								}

								$this->tempImgFile = self::destinationPath . $this->CI->session->LoginId . "img.{$type}";


								file_put_contents($this->tempImgFile, $data);

								if(file_exists($this->tempImgFile)) {

									$this->addSetValueVariable('tempImage', 'center');

									$this->templateProcessor = new TemplateProcessor($this->filename);
									sleep(1);
									$this->templateProcessor->setImageValue('tempImage', array(
										'path' => $this->tempImgFile, 
										'width' => 550, 
										'height' => 550,
										'align' => 'center'
									));									
									
									$this->saveWordFile();	

									if(file_exists($this->tempImgFile)) {
										unlink($this->tempImgFile);
									}
								}
							}
						}					
					}
				}

				$this->templateProcessor = new TemplateProcessor($this->filename);
				WordSettings::setOutputEscapingEnabled(false);
				$this->templateProcessor->setValue($key, '');
				WordSettings::setOutputEscapingEnabled(true);
				$this->saveWordFile();	
			}
		}
		
		$this->CI->load->model('TemplateModel');
		
		if($oldFileName == "") {

			$templateValue = $templateName;
			$templateArray = explode('.', $templateValue);
			$templateValue = $templateArray[0];

			$userId = $this->CI->session->LoginId;

			$param = array(
			   'userId' => $userId,
			   'templateName' => $templateValue,
			   'templateCode' => $templateCode,
			   'clientCode' => $clientCode,
			   'fileName' => $this->fileCounter . $this->fname,
			   'currentDate' => $currentDate,
			   'companyId' => $CompanyIdJson,
			   'companyName' => $CompanyNameJson,
			   'allDataJson' => $allDataJson,
			   'scheduleAFilename' => $scheduleAFilename,
			   'status' => 'Draft'
			); 

			if($this->CI->TemplateModel->saveTemplateDraft($param)) {
				chmod($this->filename, 0644);
				return $this->fileCounter . $this->fname;	
			} else {
				return FALSE;
			}
		} else {

			$templateValue = $templateName;
			$templateArray = explode('.', $templateValue);
			$templateValue = $templateArray[0];

			$param = array(
			   'templateName' => $templateValue,
			   'templateCode' => $templateCode,
			   'clientCode' => $clientCode,
			   'fileName' => $this->fileCounter . $this->fname,
			   'currentDate' => $currentDate,
			   'companyId' => $CompanyIdJson,
			   'companyName' => $CompanyNameJson,
			   'allDataJson' => $allDataJson,
			   'scheduleAFilename' => $scheduleAFilename,
			);

			if($this->CI->TemplateModel->updateTemplateDraft($param, $oldFileName)) {
				chmod($this->filename, 0644);
				return $this->fileCounter . $this->fname;	
			} else {
				return FALSE;
			} 
		}
	}

	public function ulLi($stringVal) {
	
		$startIndex = strpos($stringVal, '<ul>');
		$endIndex = strpos($stringVal, '</ul>');
		
		if($startIndex == FALSE || $endIndex == FALSE) {
			return $stringVal;
		} else {
			$block = substr($stringVal, $startIndex, $endIndex - $startIndex + 5);
			$block = str_replace("<ul>", "", $block);
			$block = str_replace("</ul>", "", $block);
			$block = str_replace("<li>", "<p>%space%&bull; ", $block);
			$block = str_replace("</li>", "</p>", $block);
		}

		$startString = substr($stringVal, 0, $startIndex);
		$endString = substr($stringVal, $endIndex + 5);

		$completeStr = $startString . $block . $endString;
		
		if(strpos($completeStr, '<ul>') != FALSE) {
			return $this->ulLi($completeStr);
		} else {
			return $completeStr;	
		}
	}

	public function olLi($stringVal) {
	
		$startIndex = strpos($stringVal, '<ol>');
		$endIndex = strpos($stringVal, '</ol>');
		
		if($startIndex == FALSE || $endIndex == FALSE) {
			return $stringVal;
		} else {
			$block = substr($stringVal, $startIndex, $endIndex - $startIndex + 5);
			$block = str_replace("<ol>", "", $block);
			$block = str_replace("</ol>", "", $block);
			$block = str_replace("<li>", "<p>%space%<li>", $block);
			$block = str_replace("</li>", "</p>", $block);

			$pos = strpos($block, '<li>');
			$i = 1;
			
			while($pos !== false) {
			    $startBlock = substr($block, 0, $pos + 4);
			    $endBlock = substr($block, $pos + 4);
			    $startBlock = str_replace("<li>", $i . ") ", $startBlock);
			    $block = $startBlock . $endBlock;
			    $pos = strpos($block, '<li>');
			    $i++;
			}
		}

		$startString = substr($stringVal, 0, $startIndex);
		$endString = substr($stringVal, $endIndex + 5);

		$completeStr = $startString . $block . $endString;
		
		if(strpos($completeStr, '<ol>') != FALSE) {
			return $this->olLi($completeStr);
		} else {
			return $completeStr;	
		}
	}

	private function fetchTable($html) {
		
		$html = trim($html);
		$tableIndex = strpos($html, "<table");
		$endIndex = strpos($html, "</table>");
		
		if($tableIndex != False) {
			$this->returnArray[] = !empty(substr($html, 0, $tableIndex)) ? substr($html, 0, $tableIndex) : "";
			$this->returnArray[] = substr($html, $tableIndex, ($endIndex + 8) - $tableIndex);

			$left = substr($html, $endIndex + 8);
			if(!empty($left) && strlen($left) > 6) {
				return $this->fetchTable($left);	
			} else {
				return $this->returnArray;	
			}
		} elseif($tableIndex == False && !empty($html) && strlen($html) > 6) {
			$this->returnArray[] = $html;
			return $this->returnArray;
		} elseif ($tableIndex == False && empty($html) || strlen($html) <= 6) {
			return $this->returnArray;
		}
	}

	private function saveTemplateScheduleA($uploadedFilename) {

		$this->templateProcessor = new TemplateProcessor($this->filename);
		WordSettings::setOutputEscapingEnabled(false);
		$this->templateProcessor->setValue('customTextArea1', '');
		WordSettings::setOutputEscapingEnabled(true);
		$this->saveWordFile();

		$generatedFile = self::scheduleAPath . $uploadedFilename;
		$targetFile = $this->filename;
		
		if(!file_exists($generatedFile) || !file_exists($targetFile)) {
			return false;
		} 

		$this->fileCounter++;
		$this->filename = self::destinationPath . $this->fileCounter . $this->fname;
		
		$dm = new DocxMerge();
		$dm->merge( [
		    $targetFile,
		    $generatedFile
		], $this->filename );

		$destinationFileName = $this->CI->session->LoginId . date('YmdHis') . rand() . ".docx";

		if(file_exists($this->filename)) {
			
			if(file_exists($targetFile)) {
				unlink($targetFile);
			}

			if(file_exists($generatedFile)) {

				if(!rename($generatedFile, FCPATH . 'assets/scheduleA/' . $destinationFileName)) {
					return false;
				}
			}			
		} else {
			return false;
		}

		return $destinationFileName;
	}

	private function addSetValueVariable($var, $align = "left") {
		$this->templateProcessor = new TemplateProcessor($this->filename);
		sleep(1);
		$phpWord = new PhpWord('Word2007');
		$section = $phpWord->addSection();

		if($align == "left") {
			$html = "<!DOCTYPE html><html><body>" . '<p>' . '${' . $var . '}' . '</p>' . $this->keyValue . "</body></html>";
		} else {
			$html = "<!DOCTYPE html><html><body>" . '<p style="text-align: center">' . '${' . $var . '}' . '</p>' . $this->keyValue . "</body></html>";
		}

		Html::addHtml($section, $html, true, false);
		$writer = IOFactory::createWriter($phpWord, 'Word2007');

		$xmlWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY, './', WordSettings::hasCompatibility());

		$containerWriter = new Container($xmlWriter, $section);
		$containerWriter->write();
		$tempXml = $xmlWriter->getData();
		$tempXml = str_replace("%space%", "    ", $tempXml);
		WordSettings::setOutputEscapingEnabled(false);
		$this->templateProcessor->setValue($this->loopKey, $tempXml);
		WordSettings::setOutputEscapingEnabled(true);
		
		$tempFileName = $this->filename;
		$this->fileCounter++;
		$this->filename = self::destinationPath . $this->fileCounter . $this->fname;
		$this->templateProcessor->saveAs($this->filename);

		if(file_exists($tempFileName)) {
			unlink($tempFileName);
		}		
	}

	private function saveWordFile() {
		$tempFileName = $this->filename;
		$this->fileCounter++;
		$this->filename = self::destinationPath . $this->fileCounter . $this->fname;
		$this->templateProcessor->saveAs($this->filename); 

		if(file_exists($tempFileName)) {
			unlink($tempFileName);
		}
		sleep(1);
	}

	private function generateTemplateCode($CompanyIdJson, $oldFileName) {

		$companyNameArray = json_decode($CompanyIdJson, true); 
		$firstCompanyId = $companyNameArray[0];

		$this->CI->db->select('clientCode');
		$this->CI->db->from('client_detail');
		$this->CI->db->where('id', $firstCompanyId);

		$query = $this->CI->db->get(); 
		$clientCodeArr = $query->result_array();		

		$clientCode = empty($clientCodeArr[0]['clientCode']) ? "" : $clientCodeArr[0]['clientCode']; // Fetched Client Code...

		if($clientCode == ""){
			$clientCode = "OTHER";
		}

		$savedClientCode = "";

		if($oldFileName != "") {
			
			$this->CI->db->select(['clientCode', 'templateCode', 'currentDate']);
			$this->CI->db->from('template');
			$this->CI->db->where('fileName', $oldFileName);
			
			$query = $this->CI->db->get(); 
			$countArr = $query->result_array();
			$savedClientCode = empty($countArr[0]['clientCode']) ? "" : $countArr[0]['clientCode'];
			$templateCode = empty($countArr[0]['templateCode']) ? "" : $countArr[0]['templateCode'];
			$currentDate = empty($countArr[0]['currentDate']) ? "" : $countArr[0]['currentDate'];
		}

		if($oldFileName == "" || $savedClientCode != $clientCode) {

			date_default_timezone_set("Asia/Calcutta");
			$currentYear = date('Y'); // Get the current year
			$date = date('Y-m-d');

			$this->CI->db->select(['clientCode', 'templateCode']);
			$this->CI->db->from('template');
			$this->CI->db->where('clientCode', $clientCode);
			$this->CI->db->like('YEAR(currentDate)', $currentYear); // Adjusted to select records from the current year

			$query = $this->CI->db->get(); 
			$countArr = $query->result_array();
			$noOfRecords = count($countArr);
			$maxIntegerArray = array();
			if($noOfRecords == 0) {
				$codeIndex = '001'; 
			} else {

				$templateCodeArray = array_column($countArr, 'templateCode');

				foreach ($templateCodeArray as $templateKey => $templateValue) {
					if($clientCode != "OTHER") {
					 	$maxIntegerArray[] = (integer) substr($templateValue, 12);
					} else {
						$maxIntegerArray[] = (integer) substr($templateValue, 13);
					}
				}

				$maxValue =  max($maxIntegerArray);	
				$maxValue++;

				if(strlen($maxValue) == 1) {
					$codeIndex = '00' . $maxValue;
				} else if(strlen($maxValue) == 2) {
					$codeIndex = '0' . $maxValue;
				} else {
					$codeIndex = $maxValue;
				}
			}

			$currentDate = $date;
			$templateCode = $clientCode . "/" . date('ymd') . '/' . $codeIndex; // Template Code...
		}

		return array(
			'clientCode' => $clientCode, 
			'templateCode' => $templateCode,
			'currentDate' => $currentDate
		);
	}
}