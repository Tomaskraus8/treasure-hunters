<?php declare(strict_types = 1);

	namespace App\Enums\Entity\Card;

	enum Type: string {
		case Shark = "shark"; // 🦈2
		case Sardines = "sardines"; // 🐟2
		case Seahorse = "seahorse"; // 🦐4
		case Dolphin = "dolphin"; // 🐬2
		case GoodGenie = "goodGenie"; // 🧞‍♂️1
		case EvilGenie = "evilGenie"; // 🧞1
		case Treasure = "treasure"; // 💎12
		case Octopus = "octopus"; // 🦑4
		case Blowfish = "blowfish"; // 🐡2
		case Anchor = "anchor"; // ⚓️2
		case Water = "water"; // 🌊17
		case Mud2 = "mud2"; // ⚁ 10
		case Mud3 = "mud3"; // ⚂ 7
		case Mud4 = "mud4"; // ⚃ 5
		case Mud5 = "mud5"; // ⚄ 5
		case Isle = "isle"; // 🏝️12
		case ArrowStraight = "arrowStraight"; // ⬆️6
		case ArrowOblique = "arrowOblique"; // ↗️6
		case TwoWayArrowStraight = "twoWayArrowStraight"; // 10
		case TwoWayArrowOblique = "twoWayArrowOblique"; // 10
		case FourWayArrowStraight = "fourWayArrowStraight"; // 5
		case FourWayArrowOblique = "fourWayArrowOblique"; // 5
		case SkippingArrowStraight = "skippingArrowStraight"; // 5
		case SkippingArrowOblique = "skippingArrowOblique"; // 5
		case EightWayArrow = "eightWayArrow"; // 4
	}