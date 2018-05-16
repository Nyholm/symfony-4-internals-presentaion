# Symfony 4 internals

This is the preparation for the Symfony 4 internals talk. Im basically building a new framework and trying to be smart
in highlighting symfony features without mentioning symfony. 

### TODO 

* [x] 7. Better regex for routing (SF4.1)
* [x] 8. Security voters
* [ ] 9. Templating
* [x] 10. Autowiring
* [x] 11. Toolbar / DataCollecotrs
* [x] 12. Exception handler


### After building of framework

We still have some problems: 

* Show toolbar when exception. => We need multiple "loops". Ei Symfony event dispatcher
* Third party support => Bundles
* Authentication (We only mentioned authorization)
* CLI => Just a new (slightly different) event loop. 

