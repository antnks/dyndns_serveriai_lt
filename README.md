# Dynamic DNS for serveriai.lt
A simple dynamic dns script to update DNS records through serveriai.lt api

# PHP script

Edit the script before uploading it to the hosting provider:

1. Generate AES key and IV: `dd if=/dev/urandom bs=1 count=16 2> /dev/null | xxd -p`
2. Create an API user: https://www.iv.lt/pagalba/Klient%C5%B3_sistemos_API#Specialus_API_naudotojas
3. Encrypt the API password using AES-CBC, ex:
```
echo -n "YourAPIpasswordGoesHere" | \
openssl enc -aes-128-cbc -K 304d08c04replace289c11d316f7ffc8 -iv d42replace7557723c30dcde3db0d3bd | xxd -p -c 64
```
4. Get your domain id: https://klientams.iv.lt/domain.php?id=xxxxx
5. Put the api user name, domain id and the encrypted password into `update_domain.php` file
6. Edit the list of domains that script allowed to update, ex `$allowed_domains = array("domain1", "domain2");`
7. Save
8. Upload

# OpenWRT cron

Add this line to cron:

```
*/15 * * * * /usr/bin/curl --silent "https://hostedserver/update_domain.php?k=304d08c04replace289c11d316f7ffc8&i=d42replace7557723c30dcde3db0d3bd&rec=domain1”
```
This command will keep `domain1` up to date with the dynamic IP address
