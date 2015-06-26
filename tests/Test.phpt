<?php

namespace Mikulas;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';


/**
 * @see http://www.typotext.cz/radce7b_1.html
 */
class Test extends TestCase
{

	/**
	 * @var Vlna
	 */
	private $vlna;

	public function setUp()
	{
		$this->vlna = new Vlna('~');
	}

	private function test($exp, $raw)
	{
		$v = $this->vlna;
		Assert::same($exp, $v($raw));
	}

	public function testDefault()
	{
		$v = new Vlna();
		Assert::same("foo v\xC2\xA0bar", $v('foo v bar'));
	}

	/**
	 * 36 Dělit do dvou řádků se nemá
	 * - zkrácený titul a příjmení nebo zkratka křestního jména a příjmení (dr./Novák, L./Pilař)
	 * - číslice a název nebo jednotka počítaného předmětu (30/kg, 5./díl, tab./7)
	 * - den a měsíc vyjádřený číslem (6./1.) a
	 * - zkratky (a./s., t./r.).
	 */
	public function test36()
	{
		$this->test('L.~Pilař', 'L. Pilař');
		$this->test('p.~Novák', 'p. Novák');
		$this->test('Ano. Pilař.', 'Ano. Pilař.');

		$this->test('MUDr.~Novák', 'MUDr. Novák');
		$this->test('dojel do Prahy. Novák byl', 'dojel do Prahy. Novák byl');

		$this->test('30~kg', '30 kg');
		$this->test('15~%', '15 %');

		$this->test('5.~díl', '5. díl');
		$this->test('Bylo jich 5. Další věta.', 'Bylo jich 5. Další věta.');

		$this->test('tab.~7', 'tab. 7');
		// $this->test('do Prahy. 7 jich', 'do Prahy. 7 jich');

		$this->test('6.~1.', '6. 1.');
		$this->test('30.~12.~2015', '30. 12. 2015');
		$this->test('a.~s.', 'a. s.');
	}

	/**
	 * 38 Jednohláskové předložky a spojky, jak neslabičné (k, s, v, z),
	 * tak slabičné (a, i, o, u), minusky i verzálky, nesmějí zůstat na konci řádku.
	 */
	public function test38()
	{
		$this->test('foo k~s~v~z~a~i~o~u~bar', 'foo k s v z a i o u bar');
	}

	/**
	 * 42 Pomlčka ve větném (interpunkčním) významu se odděluje od slov
	 * z obou stran mezerou, přičemž smí zůstat na konci řádku,
	 * avšak nemá jí řádek začínat. (Výjimkou je samozřejmě případ,
	 * kdy je pomlčka užívána místo uvozovek k označování přímé řeči.)
	 * Pokud má být za pomlčkou další interpunkce (tečka, čárka, závorka,
	 * otazník, vykřičník), přisazuje se těsně. Rovněž potřebná interpunkce,
	 * sázená před pomlčkou (závorka, uvozovka), se přisazuje bez mezery.
	 */
	public function test42()
	{
		$this->test('foo~- bar', 'foo - bar'); // hyphen
		$this->test('foo~– bar', 'foo – bar'); // ndash
	}

	/**
	 * 45 Pomlčka v ostatních případech se používá především jako znaménko
	 * »minus« 7 – 3 = 4 (oddělena zúženou mezerou, výraz 7 – 3 se nedělí
	 * do dvou řádků), [...]
	 */
	public function test45()
	{
		$this->test('7~-~3', '7 - 3'); // hyphen
		$this->test('7~–~3', '7 – 3'); // ndash
	}

	/**
	 * 62 Telefonní čísla se nesmějí dělit do dvou řádků.
	 */
	public function test62()
	{
		$this->test('602~123~345', '602 123 345');
	}

}

(new Test)->run();
