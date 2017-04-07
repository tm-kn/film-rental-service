<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Shop;

class ShopService extends BaseService {
  public function getShop($id) {
    return $this->findAndMap(
      'SELECT *
      FROM ' . $this->getDbPrefix() . 'Shop
      WHERE shopid = ?',
      [$id],
      Shop::class
    );
  }
}
