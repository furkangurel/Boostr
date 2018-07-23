 # BOOSTR - Codeigniter Easy Query Library

Simple Query Library. İnsert, Update, Delete, Find, Select, Count, Max, Min, Aggregate


## Installation

- Download the zip file of the latest release at https://github.com/furkangurel/Boostr/archive/master.zip
- Extract to your `application/libraries` directory
- In your `config/autoload.php` file, add `boostr/boostr` to `$autoload['libraries']`. So it will look like this:

  ```php
  $autoload['libraries'] = array('boostr/boostr');
  ```

## Usage
### Defining Models
Models in Boostr represent a single table to work with. To define a model, it's about the same with  CodeIgniter, but instead of extending `CI_Model`, the  model should extends `Boostr\Model` class.

*Example:* Model for table user, located in `models/user.php`

```php
class User extends Boostr\Model {
  protected $table = "user";
  protected $show = "name , surname , age";  
}
```

The `$table` property is used to tell which table the model will work with. 

### Model properties
Here are some properties you can use to customize the model

- `$table` : to define the table name. This property is mandatory to set
- `$show` : to define which  columns show. By default it uses all columns

## Querying
### İnsert
```php
User::insert($data);
```

### Update
```php
User::update($id,$data);
```
You can also update multiple data.
```php
User::update($where,$data); // $where and  $data must be an array
```

### Delete
```php
User::delete($id);
```
You can also delete multiple data.
```php
User::delete($where); // $where  must be an array
```


### Select
```php
$users = User::select($where,$order_by,$limit);  // $where, $order_by  must be an array.
foreach($users as $user)
{
  echo $user->name;
}
```

### Find
```php
$user = User::find($id);
// or
$user = User::find($where);
```

### Like
```php
$users = User::like($where,$order_by,$limit);  // $where, $order_by  must be an array.
foreach($users as $user)
{
  echo $user->name;
}
```

### Count
```php
User::count($where);  // $where  must be an array. 
```

### Max
```php
User::max('age');  // 
```

### Min
```php
User::min('age');  // 
```

### Avg
```php
User::avg('age');  // 
```

### Query
```php
$users = User::query("YOUR QUERY HERE");  //  
```


