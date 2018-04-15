# Boostr

Simple Query Library.
İnsert,
Update,
Delete,
Find,
Select

Tutorial : https://www.youtube.com/watch?v=W_jxi-bCnK4

<br>

## Usage

Config -> Autoload.php 

$autoload['config'] = array('boostr');

```
$users = new Boostr('users');  // Table Name
$users->insert($data); 
$users->update(1,$data); 
$users->delete(1);
$users->find(1);
$users->select();


```

