<?php declare(strict_types = 1);

	namespace App\Service;

	class StringGenerator {

		const LETTERS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		const NUMBERS = "0123456789";
		const LETTERS_OR_NUMBERS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		const LC_LETTERS = "abcdefghijklmnopqrstuvwxyz";
		const UC_LETTERS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		const LC_LETTERS_OR_NUMBERS = "abcdefghijklmnopqrstuvwxyz0123456789";
		const UC_LETTERS_OR_NUMBERS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		public static function randomChar(string $chars) {
			$index = rand(0, strlen($chars) - 1);
			return substr($chars, $index, 1);
		}

		public static function generateByMap(array $map): string {
			$string = "";

			foreach($map as $chars) {
				$string .= self::randomChar($chars);
			}

			return $string;
		}

		public static function randomString(string $chars, int $length): string {
			$string = "";
			for($i=0 ; $i<$length ; $i++) {
				$string .= self::randomChar($chars);
			}

			return $string;
		}
	}