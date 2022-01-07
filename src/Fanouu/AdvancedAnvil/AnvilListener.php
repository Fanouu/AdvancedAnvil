<?php

namespace Fanouu\AdvancedAnvil;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use Fanouu\AdvancedAnvil\AnvilMain;

class AnvilListener implements Listener{

	private $main;

	public function __construct(AnvilMain $main){ $this->main = $main }

	public function onInteract(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$interact $event->getBlock()->getId();

		if($interact == 145){}
	}
}