<?php

namespace Fanouu\AdvancedAnvil;

use pocketmine\Player;
use Fanouu\AdvancedAnvil\AnvilMain;
use Forms\SimpleForm;

class AnvilUi{
  
  private $main;
  
  public function __construct(AnvilMain $main){
    $this->main = $main;
    $this->money = $this->main->getPluginManager()->getPlugin("EconomyAPI");
  }
  
  public function openAnvil(Player $player){
    $form = self::createSimpleForm(function (Player $player, int $data = null){
      $result = $data;
      if($result === null){
          return true;
      }
      switch($result){
          case 0:
            $this->openRepair($player);
          break;
          
          case 1:
            $this->openRename($player);
          break;
      }
      return true;

    });
    $form->setTitle($this->main->getConfig()->getNested("AnvilUi.Title");
    $form->setContent($this->main->getConfig()->getNested("AnvilUi.Contents"));
    $form->addButton($this->main->getConfig()->getNested("AnvilUi.RepairButton"));
    $form->addButton($this->main->getConfig()->getNested("AnvilUi.RenameButton"));
    $player->sendForm($form);
  }
  
  public function openRepair(Player $player){
    $form = self::createSimpleForm(function (Player $player, int $data = null){
      $result = $data;
      if($result === null){
          return true;
      }
      switch($result){
          case 0:
            $this->getXpOrMoney($player, "item", "repair");
          break;
          
          case 1:
            $this->openAnvil($player);
          break;
      }
      return true;

    });
    $form->setTitle($this->main->getConfig()->getNested("AnvilUi.RepairUi.Title"));
    $form->setContent($this->main->getConfig()->getNested("AnvilUi.RepairUi.Contents");
    $form->addButton($this->main->getConfig()->getNested("AnvilUi.RepairUi
    Repair"));
    $form->addButton($this->main->getConfig()->getNested("AnvilUi.RepairUi.Back"));
    $player->sendForm($form);
  }
  
  public function getXpOrMoney(Player $player, $item, $type){
    if($type === "repair"){

      if($this->main->getConfig()->getNested("Anvil.XpOrMoney") === "all"){

      if($player->getXpLevel() >= $this->main->getConfig()->getNested("AnvilPrice.Repair.xp") && $this->money->myMoney($player) >= $this->main->getConfig()->getNested("AnvilPrice.Repair.money")){

        if($this->main->getConfig()->getNested("Anvil.XpOrMoneyPriority") === "xp"){


          $player->subtractXpLevels($this->main->getConfig()->getNested("AnvilPrice.Repair.xp"));
          $itemIndex = $player->getInventory()->getHeldItemIndex();
          $item = $player->getInventory()->getItem($itemIndex);
          
          if($item->getDamage > 0){
            $player->getInventory()->setItem($itemIndex, $item->setDamage(0));
          }

          $player->sendMessage($this->main->getConfig()->getNested("Anvil.repairSucces"));
        }else if($this->main->getConfig()->getNested("Anvil.XpOrMoneyPriority") === "money"){

          $this->money->reduceMoney($player, $this->main->getConfig()->getNested("AnvilPrice.Repair.money"));
            
          $itemIndex = $player->getInventory()->getHeldItemIndex();
          $item = $player->getInventory()->getItem($itemIndex);
          
          if($item->getDamage > 0){
            $player->getInventory()->setItem($itemIndex, $item->setDamage(0));
          }
          $player->sendMessage($this->main->getConfig()->getNested("Anvil.repairSucces"));
        }
      }
      }else if($this->main->getConfig()->getNested("Anvil.XpOrMoney") === "xp" && player->getXpLevel() >= $this->main->getConfig()->getNested("AnvilPrice.Repair.xp")){
        $player->subtractXpLevels($this->main->getConfig()->getNested("AnvilPrice.Repair.xp"));
        $itemIndex = $player->getInventory()->getHeldItemIndex();
        $item = $player->getInventory()->getItem($itemIndex);
          
        if($item->getDamage > 0){
          $player->getInventory()->setItem($itemIndex, $item->setDamage(0));
        }

        $player->sendMessage($this->main->getConfig()->getNested("Anvil.repairSucces"));

      }else if($this->main->getConfig()->getNested("Anvil.XpOrMoney") === "money" && $this->money->myMoney($player) >= $this->main->getConfig()->getNested("AnvilPrice.Repair.money")){

        $this->money->reduceMoney($player, $this->main->getConfig()->getNested("AnvilPrice.Repair.money"));
            
        $itemIndex = $player->getInventory()->getHeldItemIndex();
        $item = $player->getInventory()->getItem($itemIndex);
          
        if($item->getDamage > 0){
          $player->getInventory()->setItem($itemIndex, $item->setDamage(0));
        }
        $player->sendMessage($this->main->getConfig()->getNested("Anvil.repairSucces"));
      }
    }
  }
  
  public static function createSimpleForm(callable $function = null) : SimpleForm {
    return new SimpleForm($function);
  }
}