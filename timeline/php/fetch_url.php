<?php 
function fetch_wiki_data($page_name){
	// action=parse: get parsed text
// page=Baseball: from the page Baseball
// format=json: in json format
// prop=text: send the text content of the article
// section=0: top content of the page
	$url = 'http://en.wikipedia.org/w/api.php?action=parse&page='.$page_name.'&format=json&prop=text&section=0';
	$ch = curl_init($url);

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
	$c = curl_exec($ch);

	$json = json_decode($c);
	$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)
	
	//$image=$json_arr['Image'];
	// pattern for first match of a paragraph
	$pattern = '#<p>(.*)</p>#Us'; // http://www.phpbuilder.com/board/showthread.php?t=10352690
	if(preg_match($pattern, $content, $matches))
	{
		// print $matches[0]; // content of the first paragraph (including wrapping <p> tag)
		return strip_tags($matches[1]); // Content of the first paragraph without the HTML tags.
	}
}
function makeCall($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    return curl_exec($curl);
}

function wikipediaImageUrls($pageTitle) {
    $imageUrls = array();
    $imagesQuery = "http://en.wikipedia.org/w/api.php?action=query&titles={$pageTitle}&prop=images&format=json";
    $jsonResponse = makeCall($imagesQuery);
    $response = json_decode($jsonResponse, true);
    $imagesKey = key($response['query']['pages']);
    foreach($response['query']['pages'][$imagesKey]['images'] as $imageArray) {
        if($imageArray['title'] != 'File:Commons-logo.svg' && $imageArray['title'] != 'File:P vip.svg') {
           if(!isGeneric($imageArray['title'])){
			$title = str_replace('File:', '', $imageArray['title']);
            $title = str_replace(' ', '_', $title);
            $imageUrlQuery = "http://en.wikipedia.org/w/api.php?action=query&titles=Image:{$title}&prop=imageinfo&iiprop=url&format=json";
            $jsonUrlQuery = makeCall($imageUrlQuery);
            $urlResponse = json_decode($jsonUrlQuery, true);
            $imageKey = key($urlResponse['query']['pages']);
            $imageUrls[] = $urlResponse['query']['pages'][$imageKey]['imageinfo'][0]['url'];
			}
        }
    }
    return $imageUrls;
}
function isGeneric($url)
{
    $generic_strings = array(
        '_gray.svg',
        'icon',
        'Commons-logo.svg',
        'Ambox',
        'Text_document_with_red_question_mark.svg',
        'Question_book-new.svg',
        'Canadese_kano',
        'Wiki_letter_',
        'Edit-clear.svg',
        'WPanthroponymy',
        'Compass_rose_pale',
        'Us-actor.svg',
        'voting_box',
        'Crystal_',
        'transportation_inv',
        'arrow.svg',
        'Quill_and_ink-US.svg',
        'Decrease2.svg',
        'Rating-',
        'template',
        'Nuvola_apps_',
        'Mergefrom.svg',
        'Portal-',
        'Translation_to_',
        '/School.svg',
        'arrow',
        'Symbol_',
        'stub',
        'Unbalanced_scales.svg',
        '-logo.',
        'P_vip.svg',
        'Books-aj.svg_aj_ashton_01.svg',
        'Film',
        '/Gnome-',
        'cap.svg',
        'Missing',
        'silhouette',
        'Star_empty.svg',
        'Music_film_clapperboard.svg',
        'IPA_Unicode',
        'symbol',
        '_highlighting_',
        'pictogram',
        'Red_pog.svg',
        '_medal_with_cup',
        '_balloon',
        'Feature',
        'Aiga_'
    );

    foreach ($generic_strings as $str)
    {
        if (stripos($url, $str) !== false) return true;
    }

    return false;
}

function search_wiki_data($page_name){
	$wikisearch = "http://en.wikipedia.org/w/api.php?action=opensearch&search=".urlencode($page_name);
	$wikisearchlist = file_get_contents($wikisearch);
	$search_res='Link this event to --<br>';
	$json = json_decode($wikisearchlist);
	if(isset($json[1])){
		$possib_arr=$json[1];
		$count=0;
		foreach($possib_arr as $key=>$val){
			if($count==0){
				$count++;
				continue;
			}
			$search_term='<a href="link.php?page_name='.$page_name.'&wiki_name='.replace_space_with_($val).'">'.$val.'</a>';
			$search_res.=$search_term.'; ';
			$count++;
		}
	}
	
	return $search_res;
}
function replace_space_with_($inp_str){
	return str_replace(' ', '_', $inp_str);
}




function fetch_url_data($url){
$url = checkValues($url);
$return_array = array();

$base_url = substr($url,0, strpos($url, "/",8));
$relative_url = substr($url,0, strrpos($url, "/")+1);

// Get Data
$cc = new cURL();
$string = $cc->get($url);
$string = str_replace(array("\n","\r","\t",'</span>','</div>'), '', $string);

$string = preg_replace('/(<(div|span)\s[^>]+\s?>)/',  '', $string);
if (mb_detect_encoding($string, "UTF-8") != "UTF-8") 
	$string = utf8_encode($string);


// Parse Title
$nodes = extract_tags( $string, 'title' );
$return_array['title'] = trim($nodes[0]['contents']);

// Parse Base
$base_override = false; 
$base_regex = '/<base[^>]*'.'href=[\"|\'](.*)[\"|\']/Ui';
preg_match_all($base_regex, $string, $base_match, PREG_PATTERN_ORDER);
if(isset($base_match[1][0]) && strlen($base_match[1][0]) > 0)
{
	$base_url = $base_match[1][0];
	$base_override = true; 
}

// Parse Description
$return_array['description'] = '';
$nodes = extract_tags( $string, 'meta' );
foreach($nodes as $node)
{
	if(isset($node['attributes'])){
		if(isset($node['attributes']['name'])){
			if (strtolower($node['attributes']['name']) == 'description')
				$return_array['description'] = trim($node['attributes']['content']);
	}	}
}

// Parse Images
$images_array = extract_tags( $string, 'img' );
$images = array();
for ($i=0;$i<=sizeof($images_array);$i++)
{
	$img = trim(@$images_array[$i]['attributes']['src']);
	$width='';
	$height='';
	if(isset($images_array[$i]['attributes']['width'])){
		$width = preg_replace("/[^0-9.]/", '', $images_array[$i]['attributes']['width']);
	}
	if(isset($images_array[$i]['attributes']['height'])){
		$height = preg_replace("/[^0-9.]/", '', $images_array[$i]['attributes']['height']);
	}
	$ext = trim(pathinfo($img, PATHINFO_EXTENSION));
	
	if($img && $ext != 'gif') 
	{
		if (substr($img,0,7) == 'http://')
			;
		else	if (substr($img,0,1) == '/' || $base_override)
			$img = $base_url . $img;
		else 
			$img = $relative_url . $img;
		
		if ($width == '' && $height == '')
		{
			$details = @getimagesize($img);
			
			if(is_array($details))
			{
				list($width, $height, $type, $attr) = $details;
			} 
		}
		$width = intval($width);
		$height = intval($height);
		
		
		if ($width > 199 || $height > 199 )
		{
			if (
				(($width > 0 && $height > 0 && (($width / $height) < 3) && (($width / $height) > .2)) 
					|| ($width > 0 && $height == 0 && $width < 700) 
					|| ($width == 0 && $height > 0 && $height < 700)
				) 
				&& strpos($img, 'logo') === false )
			{
				$images[] = array("img" => $img, "width" => $width, "height" => $height, 'area' =>  ($width * $height),'offset' => $images_array[$i]['offset']);
				break;
			}
		}
		
	}
}
$return_array['images'] = array_values(($images));
$return_array['total_images'] = count($return_array['images']); 

/*header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($return_array);
*/

return $return_array;

exit;

}
/**
 * FUNCTIONS
 * Feel Free to put these in another file
 */


function sort_array_by_field($original,$field,$descending = false)
{
	$sortArr = array();
	
	foreach ( $original as $key => $value )
	{
		$sortArr[ $key ] = $value[ $field ];
	}

	if ( $descending )
	{
		arsort( $sortArr );
	}
	else
	{
		asort( $sortArr );
	}
	
	$resultArr = array();
	foreach ( $sortArr as $key => $value )
	{
		$resultArr[ $key ] = $original[ $key ];
	}

	return $resultArr;
}  


function checkValues($value)
{
	$value = trim($value);
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	return $value;
}


function extract_tags( $html, $tag, $selfclosing = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1' ){
 
	if ( is_array($tag) ){
		$tag = implode('|', $tag);
	}
 
	//If the user didn't specify if $tag is a self-closing tag we try to auto-detect it
	//by checking against a list of known self-closing tags.
	$selfclosing_tags = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param' );
	if ( is_null($selfclosing) ){
		$selfclosing = in_array( $tag, $selfclosing_tags );
	}
 
	//The regexp is different for normal and self-closing tags because I can't figure out 
	//how to make a sufficiently robust unified one.
	if ( $selfclosing ){
		$tag_pattern = 
			'@<(?P<tag>'.$tag.')			# <tag
			(?P<attributes>\s[^>]+)?		# attributes, if any
			\s*/?>					# /> or just >, being lenient here 
			@xsi';
	} else {
		$tag_pattern = 
			'@<(?P<tag>'.$tag.')			# <tag
			(?P<attributes>\s[^>]+)?		# attributes, if any
			\s*>					# >
			(?P<contents>.*?)			# tag contents
			</(?P=tag)>				# the closing </tag>
			@xsi';
	}
 
	$attribute_pattern = 
		'@
		(?P<name>\w+)							# attribute name
		\s*=\s*
		(
			(?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)	# a quoted value
			|							# or
			(?P<value_unquoted>[^\s"\']+?)(?:\s+|$)			# an unquoted value (terminated by whitespace or EOF) 
		)
		@xsi';
 
	//Find all tags 
	if ( !preg_match_all($tag_pattern, $html, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ){
		//Return an empty array if we didn't find anything
		return array();
	}
 
	$tags = array();
	foreach ($matches as $match){
 
		//Parse tag attributes, if any
		$attributes = array();
		if ( !empty($match['attributes'][0]) ){ 
 
			if ( preg_match_all( $attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER ) ){
				//Turn the attribute data into a name->value array
				foreach($attribute_data as $attr){
					if( !empty($attr['value_quoted']) ){
						$value = $attr['value_quoted'];
					} else if( !empty($attr['value_unquoted']) ){
						$value = $attr['value_unquoted'];
					} else {
						$value = '';
					}
 
					//Passing the value through html_entity_decode is handy when you want
					//to extract link URLs or something like that. You might want to remove
					//or modify this call if it doesn't fit your situation.
					$value = html_entity_decode( $value, ENT_QUOTES, $charset );
 
					$attributes[$attr['name']] = $value;
				}
			}
 
		}
 
		$tag = array(
			'tag_name' => $match['tag'][0],
			'offset' => $match[0][1], 
			'contents' => !empty($match['contents'])?$match['contents'][0]:'', //empty for self-closing tags
			'attributes' => $attributes, 
		);
		if ( $return_the_entire_tag ){
			$tag['full_tag'] = $match[0][0]; 			
		}
 
		$tags[] = $tag;
	}
 
	return $tags;
}




class cURL
{

	var $headers;

	var $user_agent;

	var $compression;

	var $cookie_file;

	var $proxy;

	function cURL($cookies = TRUE, $cookie = 'tmp/cookies.txt', $compression = 'gzip', $proxy = '')
	{
		$this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
		$this->headers[] = 'Connection: Keep-Alive';
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$this->compression = $compression;
		$this->proxy = $proxy;
		$this->cookies = $cookies;
		if ($this->cookies == TRUE)
			$this->cookie($cookie);
	}

	function cookie($cookie_file)
	{
		if (file_exists($cookie_file))
		{
			$this->cookie_file = $cookie_file;
		}
		else
		{
			fopen($cookie_file, 'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
			$this->cookie_file = $cookie_file;
			fclose($this->cookie_file);
		}
	}

	function get($url)
	{
		$url = str_replace("&amp;", '&', $url);

		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
		if ($this->cookies == TRUE)
			curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
		if ($this->cookies == TRUE)
			curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($process, CURLOPT_ENCODING, $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, true);
		
		
		if ($this->proxy)
			curl_setopt($process, CURLOPT_PROXY, $this->proxy);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}

	function post($url, $data)
	{
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
		if ($this->cookies == TRUE)
			curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
		if ($this->cookies == TRUE)
			curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($process, CURLOPT_ENCODING, $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		if ($this->proxy)
			curl_setopt($process, CURLOPT_PROXY, $this->proxy);
		curl_setopt($process, CURLOPT_POSTFIELDS, $data);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($process, CURLOPT_POST, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}

	function error($error)
	{
		die;
	}
}


?>