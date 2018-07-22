<?php namespace Boostr;

/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    |Boostr| Easy Database Query Library                                              |      
|----------------------------------------------------------------------------------------------------------------------|
|  Author  : Furkan Gürel                                                                                              |
|  Github  : https://github.com/furkangurel                                                                            |
|  Youtube : https://youtube.com/c/codeigniterhocasi                                                                   |
|----------------------------------------------------------------------------------------------------------------------|
*/

class Model 
{

	protected $ci = null;
	protected $table = "";

	function __construct()
	{
		$this->ci =& get_instance();
	}


	protected function find($var)
    {
        if(is_array($var))    
        {
            $results=$this->ci->db 
            ->from($this->table)
            ->where($var)
            ->get()
            ->row();
            return $results;    
        }
        $fields = $this->ci->db->field_data($this->table);
        foreach ($fields as $field)
        {
                if($field->primary_key)
                {
                    $results=$this->ci->db
                    ->from($this->table)
                    ->where($field->name,$var)
                    ->get()
                    ->row();
                    return $results;
                }
        }
        $this->error(3);        
    }

   protected function select($var=array(),$order=null,$limit=null)
    {  
    	$order=null; 
    	$by=null; 
        if(!is_array($var)){$this->error(7);}
        if($order!=null)
        {
        	if(is_array($order))
        	{
        		$row=array_keys($order);
        		$val=array_values($order);
        		$order=$row[0];
        		$by=$val[0];
        	}
            else
            {
                $this->error(4);
            }
        }
       
       
        $results=$this->ci->db
        ->from($this->table)
        ->where($var)
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

   protected function delete($var)
    {
        if(is_array($var))
        {
           $results=$this->ci
           ->db
           ->delete($this->table,$var);
           return $results;    
        }
        $fields = $this->ci->db->field_data($this->table);
        foreach ($fields as $field)
        {
                if($field->primary_key)
                {
                    $results=$this->ci
                    ->db
                    ->delete($this->table,array($field->name=>$var));
                    return $results;    
                }
        }
        $this->error(3); 
    }

   protected  function insert($var=array())
   {
        if(is_array($var))    
        {
            $results=$this->ci->db
            ->insert($this->table,$var);
            return $results;
        }
        $this->error(5);
   }

   protected function update($var,$data)
    {

        if(!is_array($data))
        {
            $this->error(6);
        }

        if(is_array($var))    
        {
            $results=$this->ci->db
            ->where($var)
            ->update($this->table,$data);
            return $results;
        }else
        {
            $fields = $this->ci->db->field_data($this->table);
            foreach ($fields as $field)
            {
                    if($field->primary_key)
                    {
                       $results=$this->ci->db
                        ->where($field->name,$var)
                        ->update($this->table,$data);
                        return $results;
                    }
            }
            $this->error(3);     
        }
    }

    protected function count($var=array())
    {
    	if(!is_array($var)){return $this->error(3);}

    	$results=$this->ci->db
        ->from($this->table)
        ->where($var)
        ->count_all_results();
        return $results;   
    }

    protected function like($var=array(),$order=null,$limit=null)
    {  
    	$order=null; 
    	$by=null; 
        if(!is_array($var)){$this->error(7);}
        if($order!=null)
        {
        	if(is_array($order))
        	{
        		$row=array_keys($order);
        		$val=array_values($order);
        		$order=$row[0];
        		$by=$val[0];
        	}
            else
            {
                $this->error(4);
            }
        }
       
       
        $results=$this->ci->db
        ->from($this->table)
        ->like($var)
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    protected function min($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_min($var)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    protected function max($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_max($var)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    protected function sum($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_sum($var)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    protected function avg($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_avg($var)
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    protected function query($query)
    {  
       return $this->ci->db->query($query)->result();  
    }

    function error($err)
    {
        switch ($err) 
        {
                case 0:
                $error='İf use the Boostr make the system on. Config => boostr.php => system="on"';
                break;
                case 1:
                $error='You have not specified a Table Name.';
                break;
                case 3:
                $error="Table named ".$this->table." was not found.";
                break;
                case 4:
                $error='Order_by data should be sent as an array().';
                break;
                case 5:
                $error='İnsert data should be sent as an array()';
                break;
                case 6:
                $error='Update data should be sent as an array()';
                break;
                case 7:
                $error='Where query should be sent as an array()';
                break;

        }
       return show_error('Boostr Error<br> '.$error, 500);
       die();
    }


	public static function __callStatic($name, $arguments)
	{
		$model = get_called_class();
		return call_user_func_array( array(new $model, $name), $arguments );
	}
	
}