# Container

We want to support caching only in prod not in development.

We need some kind of config...
I do not want to have much code in index.php, so I create a Kernel.php

Declare services in service.yaml and service_dev.yaml. 

I also switched out apcu cache to filesystem cache. It is easier to see and clear.  