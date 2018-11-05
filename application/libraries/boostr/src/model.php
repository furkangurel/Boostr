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
    protected $date ="";
    protected $slug =[];


	function __construct()
	{
		$this->ci =& get_instance();
        if (!$this->ci->db->table_exists($this->table))
        {$this->error(1);}
        $this->primary=$this->ci->db->query("SHOW KEYS FROM ".$this->table." WHERE Key_name = 'PRIMARY'")->row('Column_name'); 
        if($this->date){if($this->ci->db->field_exists($this->date, $this->table)){$this->time_ago=true;}else{$this->error(7);}}
        if($this->slug)
            {
                if(!$this->ci->db->field_exists($this->slug[0], $this->table)){$this->error(8);}
                if(!$this->ci->db->field_exists($this->slug[1], $this->table)){$this->error(8);}
            }
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
            if($this->date)
            {
                $date=$this->date;
                $results->time_ago=$this->time($results->$date);
            }
            return $results;    
        }
    
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->where($this->primary,$var)
        ->get()
        ->row();
        if($this->date)
            {
                $date=$this->date;
                $results->time_ago=$this->time($results->$date);
            }
        return $results;      
    }

   protected function select($var=array(),$order_by=null,$limit=null)
    {  

    	$order=null; 
    	$by=null; 
        if(!is_array($var)){$this->error(5);}
        if($order_by!=null)
        {

        	if(is_array($order_by))
        	{
        		$row=array_keys($order_by);
        		$val=array_values($order_by);
        		$order=$row[0];
        		$by=$val[0];
        	}else
            {
                $this->error(2);
            }
            
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
           ->delete($this->table,array($this->primary=>$var));
           return $results;    
    }

   protected  function insert($var=array())
   {
        if(is_array($var))    
        {
            if($this->slug)
            {
                $var[$this->slug[0]]=$this->sef($var[$this->slug[1]]);
            }
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
        if($this->slug)
            {
                if(isset($data[$this->slug[1]]))
                {
                    $data[$this->slug[0]]=$this->sef($data[$this->slug[1]]);
                }
                
            } 
        if(is_array($var))    
        {
            $results=$this->ci->db
            ->where($var)
            ->update($this->table,$data);
            return $results;
        }
            $results=$this->ci->db
            ->where($this->primary,$var)
            ->update($this->table,$data);
             return $results;
    }


   protected function group($grup_by=null,$var=array(),$order_by=null,$limit=null)
    {  

        $order=null; 
        $by=null; 
        if(!is_array($var)){$this->error(5);}
        if($order_by!=null)
        {

            if(is_array($order_by))
            {
                $row=array_keys($order_by);
                $val=array_values($order_by);
                $order=$row[0];
                $by=$val[0];
            }else
            {
                $this->error(2);
            }
            
        }

       
        $results=$this->ci->db
        ->from($this->table)
        ->select($this->show)
        ->group_by($grup_by)
        ->where($var)
        ->order_by($order,$by)
        ->limit($limit)
        ->get()
        ->result();
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

    protected function like($var=array(),$order_by=null,$limit=null)
    {  
    	$order=null; 
    	$by=null; 
        if(!is_array($var)){$this->error(5);}
        if($order!=null)
        {
        	if(is_array($order))
        	{
        		$row=array_keys($order_by);
        		$val=array_values($order_by);
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

    protected function join($join,$var=array(),$order_by=null,$limit=null)
    {  
        $order=null; 
        $by=null; 
        if(!is_array($var)){$this->error(5);}
        if(!is_array($join)){$this->error(6);}
        if($order!=null)
        {
            if(is_array($order))
            {
                $row=array_keys($order_by);
                $val=array_values($order_by);
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
        ->join($join[0],''.$join[1].'='.$join[2])
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
                case 7:
                $error='Date column not found';
                break;
                case 8:
                $error='Slug tables not found';
                break;

        }
       return show_error('Boostr Error<br> '.$error, 500);
       die();
    }
    function time($date) {
    
    $date =  strtotime($date);
    $zaman_farki = time() - $date;
    $saniye = $zaman_farki;
    $dakika = round($zaman_farki/60);
    $saat = round($zaman_farki/3600);
    $gun = round($zaman_farki/86400);
    $hafta = round($zaman_farki/604800);
    $ay = round($zaman_farki/2419200);
    $yil = round($zaman_farki/29030400);
    if( $saniye < 60 ){
        if ($saniye == 0){
            return "az önce";
        } else {
            return $saniye .' saniye önce';
        }
    } else if ( $dakika < 60 ){
        return $dakika .' dakika önce';
    } else if ( $saat < 24 ){
        return $saat.' saat önce';
    } else if ( $gun < 7 ){
        return $gun .' gün önce';
    } else if ( $hafta < 4 ){
        return $hafta.' hafta önce';
    } else if ( $ay < 12 ){
        return $ay .' ay önce';
    } else {
        return $yil.' yıl önce';
    }
}
function sef($text)
{
$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
$text = strtolower(str_replace($find, $replace, $text));
$text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
$text = trim(preg_replace('/\s+/', ' ', $text));
$text = str_replace(' ', '-', $text);
return $text;
}


	public static function __callStatic($name, $arguments)
	{
		$model = get_called_class();
		return call_user_func_array( array(new $model, $name), $arguments );
	}
	
}