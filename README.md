# userfull-classes in development
We can use these classes in our development depending on our need

##WebClient Class
This class can be used to invoke any webservice. It supports authentication like basic and certificaton based authentication.
we can extend it to support other authentications also. It supports all http method of json api.

##usage
```php
$objWebClient = new WebClient();
$objWebClient->WebCall();
```

##Format Class
This class can be used to convert data from any source to other source. We can convert data from xml to array, array to xml,
to json, to csv etc.

##usage
###to_xml
```php
$xmlFormatData = Format::factory($data)->to_xml('','','baseNode');
```
