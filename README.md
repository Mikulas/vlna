Vlna
====

[![Build Status](https://travis-ci.org/Mikulas/vlna.svg)](https://travis-ci.org/Mikulas/vlna)

Replaces regular space with a non-breaking space in places
where line break should not occur as per Czech language spec.

Usage
-----

```php
$vlna = new Mikulas\Vlna();

$vlna("Dr. Novák má čas v neděli!");
// Output (with ~ denoting nbsp U+00A0):
// Dr.~Novák má čas v~neděli!
```

Enforced rules
--------------

http://www.typotext.cz/radce7b_1.html

> 36 Dělit do dvou řádků se nemá
>   - zkrácený titul a příjmení nebo zkratka křestního jména a příjmení (dr./Novák, L./Pilař)
>   - číslice a název nebo jednotka počítaného předmětu (30/kg, 5./díl, tab./7)
>   - den a měsíc vyjádřený číslem (6./1.) a
>   - zkratky (a./s., t./r.).
>
> 38 Jednohláskové předložky a spojky, jak neslabičné (k, s, v, z), tak slabičné (a, i, o, u), minusky i verzálky, nesmějí zůstat na konci řádku.
>
> 42 Pomlčka ve větném (interpunkčním) významu se odděluje od slov z obou stran mezerou, přičemž smí zůstat na konci řádku, avšak nemá jí řádek začínat. (Výjimkou je samozřejmě případ, kdy je pomlčka užívána místo uvozovek k označování přímé řeči.) Pokud má být za pomlčkou další interpunkce (tečka, čárka, závorka, otazník, vykřičník), přisazuje se těsně. Rovněž potřebná interpunkce, sázená před pomlčkou (závorka, uvozovka), se přisazuje bez mezery.
>
> 45 Pomlčka v ostatních případech se používá především jako znaménko »minus« 7 – 3 = 4 (oddělena zúženou mezerou, výraz 7 – 3 se nedělí do dvou řádků), –3 stupně Celsia (pomlčka k číslici těsně); k označení rošády v šachové notaci 0–0 nebo 0–0–0 (sází se k nulám těsně); ve výčtech při opakování slov (v rejstřících – každá pomlčka zastupuje slovo, a proto se odděluje mezerou); k zesílení platnosti se pomlčka může ve větě opakovat: Už mi s tím – – – (odděluje se mezerami). Při opakování slov ve výčtech je někdy pomlčka nahrazována znakem »tilda« ~, který přejímá stejná sazební pravidla.
>
> 62 Telefonní čísla se nesmějí dělit do dvou řádků.
