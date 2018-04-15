<?php

/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    |Boostr| Easy Database Query Library 					   		 	       	   	   |	  
|----------------------------------------------------------------------------------------------------------------------|
|  Author  : Furkan Gürel																							   |
|  Github  : https://github.com/furkangurel 																		   |
|  Youtube : https://youtube.com/c/codeigniterhocasi                                                                   |
|----------------------------------------------------------------------------------------------------------------------|
*/

$config['system']="on"; // |on-off|
require_once('application/libraries/Boostr.php');


/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    	  HOW THE USE BOOSTR LİBRARY								   		    	   |	  
|----------------------------------------------------------------------------------------------------------------------|
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 1. İnclude the project								   		    	   		   |		  
|----------------------------------------------------------------------------------------------------------------------|
| Files place in related folders.After open autoload.php and $autoload['config'] = array('boostr'); Thats all ! 
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 2. Create a new Boostr Table							   		    	   	   |		  
|----------------------------------------------------------------------------------------------------------------------|
| $boostr = new Boostr('table_name'); Now use the $boostr variable make all query.
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 3. Insert Method							   		    	   	   			   |		  
|----------------------------------------------------------------------------------------------------------------------|
| $boostr = new Boostr('table_name');
| $insert_data();  // Must be an array().
| $boostr->insert($insert_data);
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 4. Update Method							   		    	   	   			   |		  
|----------------------------------------------------------------------------------------------------------------------|
| 1.USAGE 
| $boostr = new Boostr('table_name');
| $update_data();  // Must be an array().
| $boostr->update(1,$update_data);  // 1. parameter must be primary key value.
| 2.USAGE 
| $boostr = new Boostr('table_name');
| $where = array();   // Must be an array().  
| $update_data();  // Must be an array().
| $boostr->update($where,$update_data); 
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 5. Delete Method							   		    	   	   			   |		  
|----------------------------------------------------------------------------------------------------------------------|
| 1.USAGE 
| $boostr = new Boostr('table_name');
| $boostr->delete(1);  // 1. parameter must be primary key value.
| 2.USAGE 
| $boostr = new Boostr('table_name');
| $where = array();   // Must be an array().  
| $boostr->delete($where);  
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 6. Find Method							   		    	   	   			   	   |		  
|----------------------------------------------------------------------------------------------------------------------|
| 1.USAGE 
| $boostr = new Boostr('table_name');
| $boostr->find(1);  // 1. parameter must be primary key value.
| 2.USAGE 
| $boostr = new Boostr('table_name');
| $where = array();   // Must be an array().  
| $boostr->find($where);  
|----------------------------------------------------------------------------------------------------------------------|
|                                    	 6. Select Method							   		    	   	   			   |		  
|----------------------------------------------------------------------------------------------------------------------|
| $boostr = new Boostr('table_name');
| $boostr->select(); // Print the all data in table
| $where = array();   // Must be an array().  
| $boostr->select($where); // Print the conditional data
| $order_by = array(); // Must be an array()
| $boostr->select($where,$order_by) // Print the conditional data with order_by
|
*/