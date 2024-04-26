# Dynamic DNS for serveriai.lt
A simple dynamic dns script to update DNS records through serveriai.lt api

# PHP script

Edit the script before uploading it to the hosting provider:

1. Generate AES key and IV: `dd if=/dev/urandom bs=1 count=16 2> /dev/null | xxd -p`
2. Create an API user: https://www.iv.lt/pagalba/Klient%C5%B3_sistemos_API#Specialus_API_naudotojas
3. Encrypt the API password using AES-CBC, ex:
```
echo -n "YourAPIpasswordGoesHere" | \
openssl enc -aes-128-cbc -K 304d08c0481dd9d0289c11d316f7ffc8 -iv d426ce44597557723c30dcde3db0d3bd | xxd -p -c 1000000
```
4. Get your domain id: https://klientams.iv.lt/domain.php?id=xxxxx
5. Put the api user name, domain id and the encrypted password into `update_domain.php` file
6. Save
7. Upload

# OpenWRT cron

Add this line to cron:

```
*/15 * * * * /usr/bin/curl --silent "https://hostedserver/update_domain.php?k=304d08c0481dd9d0289c11d316f7ffc8&i=d426ce44597557723c30dcde3db0d3bd&rec=domain1”
```
