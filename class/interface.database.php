<?php

// interface.database.php
interface Database{
	
	public function pokaz($zm_1, $zm_2);
	public function dodaj($zm_1,$zm_2,$zm_3,$zm_4,$zm_5,$zm_6);
	public function popraw($zm_1,$zm_2,$zm_3,$zm_4,$zm_5,$zm_6,$zm_7);
	public function usun($zm);
	public function oblicz($zm_1,$zm_2);
	
}