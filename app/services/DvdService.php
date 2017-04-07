<?php namespace App\Services;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Models\Dvd;

class DvdService extends BaseService {
  public function getDvds() {
    return $this->ExecuteAndMap(
      'SELECT d.*, f.*
      FROM ' . $this->getDbPrefix() . 'DVD d
      LEFT JOIN ' . $this->getDbPrefix() . 'Film f USING(filmid)
      WHERE d.shopid = ?',
      [SHOP_ID],
      Dvd::class
    );
  }

  public function getDvd($dvdid) {
    return $this->findAndMap(
      'SELECT d.*, f.*
      FROM ' . $this->getDbPrefix() . 'DVD d
      LEFT JOIN ' . $this->getDbPrefix() . 'Film f USING(filmid)
      WHERE d.dvdid = ? AND d.shopid = ?',
      [$dvdid, SHOP_ID],
      Dvd::class
    );
  }
}
