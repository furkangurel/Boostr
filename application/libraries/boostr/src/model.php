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
    protected $show ="";


    function __construct()
    {
        $this->ci =& get_instance();
        if (!$this->ci->db->table_exists($this->table))
        {
            $this->error(3);
        }
        $this->primary=$this->ci->db->query("SHOW KEYS FROM ".$this->table." WHERE Key_name = 'PRIMARY'")->row('Column_name'); 
    }


    protected function find($var)
    {
        if(is_array($var))    
        {
            $results=$this->ci->db 
            ->from($this->table)
            ->select($this->show)
            ->where($var)
            ->get()
            ->row();
            return $results;    
        }
    
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->where($this->primary,$var)
        ->get()
        ->row();
        return $results;      
    }

   protected function select($var=array(),$order=null,$limit=null)
    {  
        $order=null; 
        $by=null; 
        if(!is_array($var)){$this->error(5);}
        if($order!=null)
        {
            if(is_array($order))
            {
                $row=array_keys($order);
                $val=array_values($order);
                $order=$row[0];
                $by=$val[0];
            }
                $this->error(2);
        }
       
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->where($var)
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
        return $results;
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
           $results=$this
           ->ci
           ->db
           ->delete($this->table,array($primary=>$var));
           return $results;    
    }

   protected  function insert($var=array())
   {
        if(is_array($var))    
        {
            $results=$this->ci->db
            ->insert($this->table,$var);
            return $results;
        }
        $this->error(3);
   }

   protected function update($var,$data)
    {

        if(!is_array($data))
        {
            $this->error(4);
        }

        if(is_array($var))    
        {
            $results=$this->ci->db
            ->where($var)
            ->update($this->table,$data);
            return $results;
        }
            $results=$this->ci->db
            ->where($primary,$var)
            ->update($this->table,$data);
             return $results;
        
    }

    protected function count($var=array())
    {
        if(!is_array($var)){return $this->error(5);}

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
        if(!is_array($var)){$this->error(5);}
        if($order!=null)
        {
            if(is_array($order))
            {
                $row=array_keys($order);
                $val=array_values($order);
                $order=$row[0];
                $by=$val[0];
            }
                $this->error(2);
        }
       
       
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->like($var)
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
        return $results;  
    }

    protected function join($join,$var=array(),$order=null,$limit=null)
    {  
        $order=null; 
        $by=null; 
        if(!is_array($var)){$this->error(5);}
        if(!is_array($join)){$this->error(6);}
        if($order!=null)
        {
            if(is_array($order))
            {
                $row=array_keys($order);
                $val=array_values($order);
                $order=$row[0];
                $by=$val[0];
            }
                $this->error(2);
        }

        $joinprimary=$this->ci->db->query("SHOW KEYS FROM ".$join[0]." WHERE Key_name = 'PRIMARY'")->row('Column_name'); 
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->where($var)
        ->join($join[0],''.$join[0].'.'.$joinprimary.'='.$join[1])
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
        return $results;  
    }

    protected function min($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_min($var)
        ->get()
        ->result();
        return $results;   
    }

    protected function max($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_max($var)
        ->get()
        ->result();
        return $results;   
    }

    protected function sum($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_sum($var)
        ->get()
        ->result();
        return $results; 
    }

    protected function avg($var)
    {  
        $results=$this->ci->db
        ->from($this->table)
        ->select_avg($var)
        ->get()
        ->result();
        return $results;  
    }

    protected function query($query)
    {  
       return $this->ci->db->query($query)->result();  
    }

    function error($err)
    {
        switch ($err) 
        {
                case 1:
                $error="Table named ".$this->table." was not found.";
                break;
                case 2:
                $error='Order_by data should be sent as an array().';
                break;
                case 3:
                $error='İnsert data should be sent as an array()';
                break;
                case 4:
                $error='Update data should be sent as an array()';
                break;
                case 5:
                $error='Where query should be sent as an array()';
                break;
                case 6:
                $error='Join query should be sent as an array()';
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