<?php
/*
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2005 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org/
 ----------------------------------------------------------------------

 LICENSE

	This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
*/

// Original Author of file: Walid Nouh (walid.nouh@atosorigin.com)
// Purpose of file:
// ----------------------------------------------------------------------
class BackendCSV extends Backend{
	
    function BackendCSV() {
    	$this->injectionDatas = new InjectionDatas;
    }

	function initBackend($newfile,$delimiter)
	{
    	$this->file = $newfile;
    	$this->delimiter = $delimiter;
	}
	function read()
	{
		$fic = fopen($this->file, 'r');

		while (($data = fgetcsv($fic, 3000, $this->delimiter)) !== FALSE)
		{  
			$line = parseLine($fic,$data);
			//If line is not empty
			if ($line[0][0] != null)
				$this->injectionDatas->addToDatas($line);
		}
 	 	fclose($fic);
	}
	
	function readLinesFromTo($start_line, $end_line)
	{
		$row = 0;
		$fic = fopen($this->file, 'r');

		while ((($data = fgetcsv($fic, 3000, $this->delimiter)) !== FALSE) && $row <= $end_line) { 
			if ($row >= $start_line && $row <= $end_line)
				$this->injectionDatas->addToDatas(parseLine($fic,$data));
			$row++;
		}


 	 	fclose($fic);
		
	}
	
	/*
	 * Try to parse an input file
	 * @return true if the file is a CSV file
	 */
	function isFileCorrect()
	{
		return true;
	}
}

?>