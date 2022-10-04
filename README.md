
# Editable

editable and historiable data for crud operations to save request consumptions and bandwidth, also for make history for all changes done in the request.



## Features

- Save all Edits done on your DB table with one model configuration
- this makes a DB table called ( edit_history ) with morphMany for any of your chosen models you need to track its edit history.
## Upcomoing Features
- View history done in all of your Models ( You don't need to code this, I'll do it for you ).


## Author

- [Mahmoud Arafat](https://mahmoud-arafat.com)
   ( [@mahmoudarafat](https://github.com/mahmoudarafat) )


-----
## Installation

First, we run 
```
  composer require mahmoudarafat/edit-history
```

Then, we should add the package to [ config/app.php ]

```
  'providers' => [
    ....
   
      \MahmoudArafat\EditHistory\EditHistoryServiceProvider::class,
   
    ....
  ],
```
Now, we can publish the package

```
  php artisan vendor:publish
```
##### [Choose] 
  ### MahmoudArafat\EditHistory\EditHistoryServiceProvider


And finally, we do this Artisan command to add the [ edit_history ] table to your DB.
```
 php artisan edithistory:table
```
That's it, Enjoy!

------
## Usage/Examples

``` php
<?php

namespace App\Models;
// import the package
use MahmoudArafat\EditHistory\Traits\Historyable;

class User extends Model
{
    // use the package in model
    use Historyable;

}
```

for custom ignored columns to stop track:
Add [ ignoreHistoryColumns ] property in model: 

``` php
<?php

namespace App\Models;
// import the package
use MahmoudArafat\EditHistory\Traits\Historyable;

class User extends Model
{
    // use the package in model
    use Historyable;

   // ignore those here
    public $ignoreHistoryColumns = ['name', 'updated_at'];

}
```

