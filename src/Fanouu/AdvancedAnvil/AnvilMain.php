<?php

namespace Fanouu\AdvancedAnvil;

use pocketmine\plugin\PluginBase;
use Fanouu\AdvancedAnvil\AnvilUi;

class AnvilMain extends PluginBase{
  
  private static $instances;
  
  public function onEnable(){
    $this->getLogger()->("AdvancedAnvil - This plugin was made by Fan");
    
    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    
    if($this->getConfig()->getNested("Anvil.XpOrMoney") === "money" || $this->getConfig()->getNested("Anvil.XpOrMoney") === "all"){
        $this->money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		    if(is_null($this->money)){
			     $this->getServer()->getPluginManager()->disablePlugin($this);
			     $this->getServer()->getLogger()->error("EconomyAPI no't Found");
		    }
    }
  }
  
  public function getAnvilUi(): AnvilUi{
    return new AnvilUi($this);
  }
}