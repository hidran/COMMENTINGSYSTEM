<?php
namespace Blog\Db;

/**
 *
 * @author arias
 *        
 */
interface DbConnection
{
    const PDOINT = 1;
    const PDOSTR = 2;
    const PDONULL = 0;
    public function  execute($statement);
    public function  query($query);
    /**
     * return driver's instance
     */
    public function  getHandler();
   
}

?>