<?php

namespace App\Entity;

use App\Entity\Whisky;
use App\Entity\WhiskyImg;

class Panier
{
    private $liste;
    private $nbart;

    public function __construct()
    {
        $this->liste=[];
    }

    public function AddOneProduct(Whisky $whisky, $img)
    {
        $id = $whisky->getId();
        if (!array_key_exists($id, $this->getListe())) {
            $this->liste[$whisky->getId()] = array($whisky, 1, $img);
        }
    }

    public function checkProductExist(Whisky $whisky){
        $id = $whisky->getId();
        if (!array_key_exists($id, $this->getListe())) {
            return true;
        }else{return false;}
    }

    public function AddProducts(Whisky $whisky, $qte, $img)
    {
        $id = $whisky->getId();
        if (!array_key_exists($id, $this->getListe()) && $qte > 0) {
            $this->liste[$whisky->getId()] = array($whisky, $qte, $img);
        }
    }



    public function getNbart(){
        $this->nbart = count($this->liste);
        return $this->nbart;
    }

    /**
     * @return array
     */
    public function getListe(): array
    {
        return $this->liste;
    }

    public function checkOutList()
    {
        $tab = $this->getListe();
        $array = [];
        foreach ($tab as $id => $item ){
            $array[$id]=$item[1];
        }
        return $array;
    }

    public function removeProduct($id)
    {
        unset($this->liste[$id]);
    }

    public function listProducts()
    {
        $tableau=array();
        foreach ($this->getListe() as $id => $tab)
        {
            array_push($tableau, $tab[0]);
        }
        return $tableau;
    }

    public function changeQte($id, $x)
    {
        $this->liste[$id][1] = $x;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getListe() as $key => $tab)
        {
            $total += $tab[0]->getPrix()*$tab[1];
        }
        return $total;
    }

    public function getTotalHt()
    {
        $totalHt = round($this->getTotal()*(5/6), 2);

        return $totalHt;
    }

}