<?php

/**
 * 
 * @author Raymond
 *
 */

class college_profile extends Spine_SuperModel
{
	public	$path_universities_profiles	=	'api/data/universities_profiles/';
	
	public function getProfile ( $college_code )
	{
		$source = '';
		
		$z = new ZipArchive();
		if ($z->open($this->path_universities_profiles.'educounsel.universities.zip')) 
		{
			$fp = $z->getStream('educounsel.universities/edu'.$college_code.'.txt');
			
			if(!$fp) exit("failed\n");
	
			while (!feof($fp)) 
			{
				$source .= fread($fp, 2);
			}
			
			fclose($fp);
		}
		
		//$source	=	file_get_contents('zip://'.$filename);
		$source	=	substr($source, strpos($source, '<body>'), ((strpos($source, '</body>') + 7) - strpos($source, '<body>')));
		
		if (!$source)
		{
			return FALSE;
		}
		
		$search			=	'<script type="text/javascript" src="https://common.collegeboard.org/webanalytics/js/web_analytics_header.js"></script>';
		$source		=	str_replace($search, '', $source);
		$search			=	'<h3>www.collegeboard.org</h3>';
		$source		=	str_replace($search, '', $source);
		$search			=	'<p><span class="bold">College Search</span> helps you research colleges and universities, find schools that match
         your preferences,
         and add schools to a personal watch list.</p>';
		$source		=	str_replace($search, '', $source);
			
		return $source;
	}	
}