<?php 
ini_set('display_errors',1);

Class Test{
	/*
	 * TASK #1 Sorting
     * @Param : string $string — Stirng needs to be sorted  
     * @description: Function gets a string or a number as a parameter and sort it in 
     * 	decreasing order using bubble sort algorithm and return the values in comma separated form
     * @return : string
     * @auther: Dhananjay Singh
     * */
	function mysort($string=''){
		if($string!=''){
			$str_arr = str_split($string);
			
			$array_size = count($str_arr);
			echo "String before sort: <br>";
			for ( $i = 0; $i < $array_size; $i++ )
			   echo $str_arr[$i];

			for ( $i = 0; $i < $array_size; $i++ )
			{
			   for ($j = 0; $j < $array_size; $j++ )
			   {
				  if ($str_arr[$i] > $str_arr[$j])
				  {
					 $temp = $str_arr[$i];
					 $str_arr[$i] = $str_arr[$j];
					 $str_arr[$j] = $temp;
				  }
			   }
			}

			echo "<br> Numbers after sort: <br>";
			for( $i = 0; $i < $array_size; $i++ ){
			   $new_str[] = $str_arr[$i];
			}
			echo implode(',',$new_str);
		}else{
			echo 'Invalid String';	
		}
	}

	/*
	 * //TASK #2
	 * @Param : string 
	 * @description: get a string check for following conditions
	 * - consist of two or more labels, with a dot '.' inbetween
	 * - have up to 63 characters in each label
	 * - have each label begin and end with a digit or letter
	 * - have digits, letters, or hyphens for all other characters in each label
	 * - (optional) end with an empty label such as 'domain.com.'
	 * - contain no more than 253 total characters, or 254 if the domain name ends with an empty label 
	 * @return : string
	 * @auther: Dhananjay Singh
	 * */	 
	function checkdomain($string=''){
		echo preg_match("/^(([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z?\.]{2,6}){0,253}$/", $string)?'MATCH':'NO MATCH';
	}

	/* TASK #3
     * @Param : int 
     * @description: Function gets a integer value as a parameter and returns the count 
     *    of 1s in the binary value of the input 
     * @return : int
     * @auther: Dhananjay Singh
     * */
	function countones($num=''){
		if(is_int($num)){
			$bin = decbin( $num );
			$bin_arr = str_split($bin);
			$counts = array_count_values($bin_arr);
			return $counts[1];
		}else{
			echo 'Invalid number';	
		}
	}

	/* Task#4 Sanitize
	 * @Params	 - String $html - HTML supplied to validate/sanitize.
   	 * @Params	 - Array $allowed - array of allowed elements in validated html, Keys are in array will be allowed tags and values are array of allowed attributes
	 * for related tag.
	 * @Params	- Array $disallowed - array of disallowed tags which we need to remove with content.
	 * @description - Function to Sanitize HTML Content as per argument passed.
	 * @Output	- String
	 * @Author	- Dhananjay Singh 
	 * */
	function sanitize($html,$allowed=array(),$disallowed=array('script','link','style')){
		if(!empty($html)){
			if(count($allowed)>0){
				/**----Code to remove Disallowed tags with content ----**/
				foreach($disallowed as $dis){
					$dis_regex[] = "@<".$dis."[^>]*?>.*?</".$dis.">@siu";
				}
				$html = preg_replace($dis_regex,"",$html);
				/**--------**/
				
				/**----Code to keep allowed tags----**/
				$strip_tags = '';
				$tag_attr_arr  = array();	
				foreach($allowed as $tag=>$attributes)
				{
					if($tag===0){
						$tag = $attributes;
					}
					$strip_tags .= '<'.$tag.'>';
					$tag_attr_arr[$tag] = $attributes;
				}
				$clean_html = strip_tags($html,$strip_tags);
				/**--------**/
				
				$dom = new DomDocument;// Created new Document object
				$dom->loadHTML($clean_html);
				$xpath = new DOMXPath($dom);
				$nodes = $xpath->query('//@*');
				
				foreach($nodes as $node){
					if(!empty($tag_attr_arr[$node->parentNode->tagName])){
						if(!in_array($node->nodeName,$tag_attr_arr[$node->parentNode->tagName])){
							$node->parentNode->removeAttribute($node->nodeName); // remove disallowed attributes
						}
					}
				}
			// gets an object with <body> element (including all its content)
			$body = $dom->getElementsByTagName('body')->item(0);
			// adds the $body content into a string, and outputs it
			return $strbody = $dom->saveHTML($body);
			}
			else
			{
				return $html;
			}
			
		}
		else
		{
			return "Invalid HTML!";
		}
	}	
	
	/* TASK #5
	* @Params string $s — UTF-8 string to process;
	* @Params int $len — the desired length of the string, determines how many characters to truncate to
	* @Params string $etc — text string that replaces the truncated text, its length is included in the $len argument
	* @Params boolean $break_words — whether or not to truncate at a word boundary (false) or at the exact character (true). When false and the first word is longer than $len characters, return the first $len-strlen($etc) characters of the first word
	* @Params boolean $middle — whether the truncation happens at the end of the string (false) or in the middle of the string (true). When true, word boundaries are ignored.
	* @description: - Function to truncate string as per the given parameter :
	* @Output	- $content,$s(string)  
	* @Author	- Dhananjay Singh
	* */
	
	
	function truncateString($s, $len=0, $etc = '...', $break_words = false, $middle = false) 
	{
		if($len>0){
			if($break_words)
			{
				if($middle)
				{
					$txt_length = strlen($s);
					$max_length = $len-strlen($etc);
					$content = substr_replace($s, $etc, $max_length/2, $txt_length-$max_length);
				}
				else
				{
					$remove_char = strlen($etc);
					$content =  substr($s,0,$len-$remove_char);
				}
			}
			else
			{
				$content =  preg_replace('/\s+?(\S+)?$/', '', substr($s, 0,$len));
			}
			if($etc!='' && !$middle)
			{
				$content = $content.$etc;
			}
			return $content; 
		}
		else
		{
			return $s;
		}
	}

} //end class test


$inst = new Test;

//Sortin Task#1
//$inst->mysort('34521');

//Domain name check Task#2
//$string = '00001234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.com.';
//$inst->checkdomain($string);

//count binary number Task#3
//echo $inst->countones(12);

//Sanitize Task#4
//$html = "<div><p align='left' onclick='alert(1)'>sample <b><i>text</i></b><script>alert(2);</script></p></div>";
//echo $inst->sanitize($html,array('b','p'=>array('align')));

//Truncate string Task#5
//$s = 'Two Sisters Reunite after Eighteen Years at Checkout Counter.';
//echo $inst->truncateString($s,30,'...',true);
