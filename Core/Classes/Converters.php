<?php  

include "Dictionaries.php";

class Converters 
{


	public function binToText($bin) : string
	{	

		$dictionary = new Dictionaries();
		$dictionaryAscii = $dictionary->getDictionary();

		//Contain the string result
		$completeWord = null;

		$binaries = explode(" ", $bin);
		$decimals = array();

		for($i = 0; $i < count($binaries); $i++)
		{
			array_push($decimals, bindec($binaries[$i]) );
		}

		foreach ($decimals as $decimal) 
		{
			
			if (in_array($decimal, $dictionaryAscii))	
			{	
				$completeWord .= implode(",", array_keys($dictionaryAscii, $decimal));
			}

		}

		return $completeWord;

	}


	public function textToBin($text) : string 
	{

		$dictionary = new Dictionaries();
		$dictionaryAscii = $dictionary->getDictionary();

		$resultingBinary = null;

		for($i = 0; $i < strlen($text); $i++)
		{	

			if (array_key_exists($text[$i], $dictionaryAscii))
			{
				$resultingBinary .= " " . strval(decbin($dictionaryAscii[$text[$i]]));
			}
		}

		return $resultingBinary;

	}	

}

$converter = new Converters();


//echo "<br><br> Resultado => " . $converter->text_to_bin("hola mundo");

//echo "<br><br> Resultado => " . $converter->bin_to_text("1101000 1101111 1101100 1100001 100000 1101101 1110101 1101110 1100100 1101111");

//TODO: Trabajar en el index y crear un front sencillo con ajax para hacer las pruebas 


?>