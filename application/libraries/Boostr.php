<?php

/*
|----------------------------------------------------------------------------------------------------------------------|
|                                    |Boostr| Easy Database Query Library                                              |      
|----------------------------------------------------------------------------------------------------------------------|
|  Author  : Furkan Gürel                                                                                              |
|  Github  : https://github.com/furkangurel                                                                            |
|  Youtube : https://youtube.com/c/codeigniterhocasi                                                                   |
|----------------------------------------------------------------------------------------------------------------------|
*/


class Boostr
{
    public $table=null;

    function __construct($table=null) 
    {
        $this->table=$table;
        $ci=get_instance();
        if(config_item('system')=="off")
        {
            $this->error(0);
        }
        if($table==null)
        {
            $this->error(1);
        }elseif(!$ci->db->table_exists($table))
        {
            $this->error(3);
        }
    }

    function find($var)
    {
        $ci=get_instance();
        if(is_array($var))    
        {
            $results=$ci->db 
            ->from($this->table)
            ->where($var)
            ->get()
            ->row();
            return $results;    
        }
        $fields = $ci->db->field_data($this->table);
        foreach ($fields as $field)
        {
                if($field->primary_key)
                {
                    $results=$ci->db
                    ->from($this->table)
                    ->where($field->name,$var)
                    ->get()
                    ->row();
                    return $results;
                }
        }
        $this->error(3);        
    }

    function select($var=array(),$order=null)
    {   
        $ci=get_instance();

        if(!is_array($var))
            {
                $this->error(7);
            }

        if($order!=null)
        {
            if(!is_array($order))
            {
                $this->error(4);
            }
        }
        

        if($order==null)
        {
             $results=$ci->db
            ->from($this->table)
            ->where($var)
            ->get()
            ->result();
            return $results;
        }
        $row=array_keys($order);
        $val=array_values($order);

        $results=$ci->db
        ->from($this->table)
        ->where($var)
        ->order_by($row[0],$val[0])
        ->get()
        ->result();
        return $results;
        $this->error(3);    
    }

    function delete($var)
    {
        $ci=get_instance(); 
        if(is_array($var))    // Variable Arraymı
        {
           $results=$ci
           ->db
           ->delete($this->table,$var);
           return $results;    
        }
        $fields = $ci->db->field_data($this->table);
        foreach ($fields as $field)
        {
                if($field->primary_key)
                {
                    $results=$ci
                    ->db
                    ->delete($this->table,array($field->name=>$var));
                    return $results;    
                }
        }
        $this->error(3); 
    }

     function insert($var=array())
   {
        $ci=get_instance();
        if(is_array($var))    
        {
            $results=$ci->db
            ->insert($this->table,$var);
            return $results;
        }
        $this->error(5);
   }

    function update($var,$data)
    {
        $ci=get_instance();

        if(!is_array($data))
        {
            $this->error(6);
        }

        if(is_array($var))    
        {
            $results=$ci->db
            ->where($var)
            ->update($this->table,$data);
            return $results;
        }else
        {
            $fields = $ci->db->field_data($this->table);
            foreach ($fields as $field)
            {
                    if($field->primary_key)
                    {
                       $results=$ci->db
                        ->where($field->name,$var)
                        ->update($this->table,$data);
                        return $results;
                    }
            }
            $this->error(3);     
        }
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
       echo $error;
       die();
    }

}