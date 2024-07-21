# Techstacks 
## Custom Magento 2 Module for Legacy Medical Supplies Listing Fee

### version v0.2.1

## INSTALLATION

Run the following command:
```bash
composer require techstacks/legacy-listing-fee
```

```bash
bin/magento setup:upgrade  
bin/magento setup:di:compile
bin/magento indexer:reindex
bin/magento setup:static-content:deploy -f  
bin/magento cache:flush
```  

Done.

## License
The Techstacks Custom Magento 2 Module for Legacy Medical Supplies Listing Fee for Magento 2 is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
