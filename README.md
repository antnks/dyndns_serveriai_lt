# Dynamic DNS for serveriai.lt
A simple dynamic dns script to update DNS records through serveriai.lt api

# PHP script

Edit the script before uploading it to the hosting provider:

1. Generate AES key and IV: `dd if=/dev/urandom bs=1 count=16 2> /dev/null | xxd -p`
2. Create an API user: https://www.iv.lt/pagalba/Klient%C5%B3_sistemos_API#Specialus_API_naudotojas
3. Encrypt the API password using AES-CBC: 
4. Put the user name, account id and the encrypted password
5. Save
6. Upload

# OpenWRT cron

Add this line to cron:

```
```

