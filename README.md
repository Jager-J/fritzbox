# Useful Fritzbox Script Collection - 2023
Collection of useful scripts for the fritzbox model XXXX
## The dynamic_ip script
If you don't like to pay more for a static IP you can use this script as an alternative, if your public ip changes it automatically updates all provided domains.
## How to set up the script
### Log into your fritzbox using http://fritz.box
### Go to Internet > Permit Access
![alt text](https://i.postimg.cc/4NGKzNKn/Screenshot-2023-03-20-181002.png)
### Go to DynDNS on the right side
![alt text](https://i.postimg.cc/vHv4XF9h/Screenshot-2023-03-20-181019.png)
### Enter following configuration
## DynDNS:
enable = Checkbox YES
## Update URL: 
should be pointing to your local webserver that has access to the internet
http://192.168.x.x/?ip=<ipaddr>
XX representing missing ip places
<ipaddr> Will pass the newly optained public ip address and sent it to the webserver as get parameter
http://192.168.x.x/?ip=127.0.0.1

### Domain Not needed will be provided inside the script
### Username not needed no authentication by username
### No authentication by password

### Additional Information to the configuration:
You can move the script on your webserver anywhere it doesn't have to stay in the root folder, be sure to update the url in the fritzbox configuration to point to the script.

<table>
  <tr>
    <td valign="top"><img src="https://github-readme-stats.vercel.app/api/top-langs/?username=Jager-J&layout=compact&show_icons=true&title_color=ffffff&icon_color=34abeb&text_color=daf7dc&bg_color=151515"/></td>
    <td valign="top"><img src="https://github-readme-stats.vercel.app/api?username=Jager-J&show_icons=true&title_color=ffffff&icon_color=34abeb&text_color=daf7dc&bg_color=151515"/></td>
  </tr>
</table>
