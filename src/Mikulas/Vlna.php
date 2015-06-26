<?php

namespace Mikulas;


class Vlna
{

	/** @var string */
	const NBSP = "\xC2\xA0";


	/** @var string */
	protected $separator;


	public function __construct($separator = self::NBSP)
	{
		$this->separator = $separator;
	}


	private function v(&$text, $before, $after = NULL)
	{
		// look behind intentionally not used because only fixed length is supported
		$text = preg_replace("~($before) (?=\s*($after))~um", "$1$this->separator", $text);
	}


	/**
	 * Inserts non-breaking space after single letter words, between
	 * dates and after abbreviations followed by lowercase letter.
	 *
	 * @param string $t
	 */
	public function __invoke($t)
	{
		$this->v($t, '\p{Lu}\.', '\p{Lu}'); // L. Pilař
		$this->v($t, '\b\p{Ll}\.', '\p{Lu}'); // p. Novák

		/** @see https://cs.wikipedia.org/wiki/Akademick%C3%BD_titul */
		$this->v($t, '(akad|Bc|BcA|CSc|doc|Dr|DrSc|DSc|ICDr|Ing|JUDr|MDDr|MgA|Mgr|MSDr|MUDr|MVDr|PaedDr|Ph\.D|PharmDr|PhDr|PhMr|prof|RCDr|RNDr|RSDr|RTDr|Th\.D|ThDr|ThLic|ThMgr|DiS)\.');

		$this->v($t, '\d'); // 30 kg
		$this->v($t, '\d\.', '\p{Ll}'); // 15. km
		$this->v($t, '\w\.', '\d|\p{Ll}'); // tab. 7, a. s.

		$this->v($t, '\b(k|s|v|z|a|i|o|u)');

		$this->v($t, '', '-|–'); // hyphen or ndash
		$this->v($t, '-|–', '\d'); // hyphen or ndash in '7 - 3'

		return $t;
	}

}
