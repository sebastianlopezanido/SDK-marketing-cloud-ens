# SDK-marketing-cloud-ens
SDK Marketing cloud integration with event notification server


This Laravel api was made to integrate Marketing cloud and managed events notification 

Marketing cloud Documentation:
-https://developer.salesforce.com/docs/marketing/marketing-cloud/guide/ens.html
-https://developer.salesforce.com/docs/marketing/marketing-cloud/guide/createCallback.html

requirements: Docker
 
steps:
1. Clone  
`git clone https://github.com/sebastianlopezanido/SDK-marketing-cloud-ens.git`
2. Config .env with your enviroment variables.
3. Build app
`docker-compose build --no-cache`
4. Run Cointainer
`docker-compose up -d` 
5. Execute command console into container
`docker exec -ti sdk_mkc /bin/bash`
6. Install and update composer
`composer install`
`composer update`


