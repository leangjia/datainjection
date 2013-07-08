<?php
/*
 * @version $Id$
 LICENSE

 This file is part of the datainjection plugin.

 Datainjection plugin is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Datainjection plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with datainjection. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 @package   datainjection
 @author    the datainjection plugin team
 @copyright Copyright (c) 2010-2013 Datainjection plugin team
 @license   GPLv2+
            http://www.gnu.org/licenses/gpl.txt
 @link      https://forge.indepnet.net/projects/datainjection
 @link      http://www.glpi-project.org/
 @since     2009
 ---------------------------------------------------------------------- */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginDatainjectionComputer_SoftwareVersionInjection extends Computer_SoftwareVersion
                                                implements PluginDatainjectionInjectionInterface {

   static function getTypeName($nb=0) {
      
      return __('Computer');
   }
   
   static function getTable() {
   
      $parenttype = get_parent_class();
      return $parenttype::getTable();
      
   }


   function isPrimaryType() {
      return false;
   }


   function connectedTo() {
      return array('Software', 'SoftwareVersion');
   }


   function getOptions($primary_type = '') {

      $tab[110]['table']        = 'glpi_computers';
      $tab[110]['field']        = 'name';
      $tab[110]['linkfield']    = 'name';
      $tab[110]['name']         = self::getTypeName()." - ".__('Name');
      $tab[110]['injectable']   = true;
      $tab[110]['displaytype']  = 'dropdown';
      $tab[110]['checktype']    = 'text';
      $tab[110]['storevaluein'] = 'computers_id';

      $tab[111]['table']        = 'glpi_computers';
      $tab[111]['field']        = 'serial';
      $tab[111]['linkfield']    = 'serial';
      $tab[111]['name']         = self::getTypeName()." - ".__('Serial Number');
      $tab[111]['injectable']   = true;
      $tab[111]['displaytype']  = 'dropdown';
      $tab[111]['checktype']    = 'text';
      $tab[112]['storevaluein'] = 'computers_id';

      $tab[112]['table']        = 'glpi_computers';
      $tab[112]['field']        = 'otherserial';
      $tab[112]['linkfield']    = 'otherserial';
      $tab[112]['name']         = self::getTypeName()." - ".__('Inventory number');
      $tab[112]['injectable']   = true;
      $tab[112]['displaytype']  = 'dropdown';
      $tab[112]['checktype']    = 'text';
      $tab[112]['storevaluein'] = 'computers_id';

      return $tab;
   }


   /**
    * Standard method to add an object into glpi
 
    *
    * @param values fields to add into glpi
    * @param options options used during creation
    * @return an array of IDs of newly created objects : for example array(Computer=>1, Networkport=>10)
    *
   **/
   function addOrUpdateObject($values=array(), $options=array()) {

      $lib = new PluginDatainjectionCommonInjectionLib($this, $values, $options);
      $lib->processAddOrUpdate();
      return $lib->getInjectionResults();
   }

   function addSpecificMandatoryFields() {
      return array('computers_id' => 1, 'softwareversions_id' => 1);
   }
   
   function addSpecificNeededFields($primary_type, $values) {
      if (isset($values['SoftwareVersion'])) {
         $fields['softwareversions_id'] = $values['SoftwareVersion']['id'];
      }
      return $fields;
   }

}

?>