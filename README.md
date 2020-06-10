# Stock-Market

# Instructions for installing Nginx
NOTE: It is strongly recommended that nginx be run in a Linux environment as this is the optimal environment for this software. Ubuntu 18.04 was used for the duration of this project.


Linux (Strongly Recommended):
1. install the nginx software
	sudo apt-get update
	sudo apt-get install nginx

2. replace /etc/nginx/nginx.conf with the nginx.conf file provided in this submission -- be sure to keep this file in this directory
3. Inside the nginx.conf file, find the following line:
	
	'include /home/ubuntu/Zack/wpl/stockserver.conf'
	
	and replace the with path to stockserver.conf on your machine

4. To check that the configuration files are properly set up, run the command:
	sudo nginx -t

5. To start the nginx service, run the command:
	sudo systemctl start nginx

6. Run the following to ensure it has started:
	sudo systemctl status nginx

Windows installation:
	 
See Nginx website for instructions to install on Windows:
	http://nginx.org/en/docs/windows.html

OSX:

See the following link for OSX instructions:

https://www.javatpoint.com/installing-nginx-on-mac



# Instructions for starting the Stock Server (Stock Exchange Web Service):

1. Install python3 if not already installed

2. Run the following command:
	python3 stockserver.py

3. In Linux, see /var/log/nginx/access.log and /var/log/nginx/error.log for normal and error log files.


# Website is hosted , url is given below
- http://zeropixel.in/ALKESH/LATEST/login.php

# Screenshots
![Picture2](https://user-images.githubusercontent.com/20412445/84295706-8c4e7580-ab10-11ea-8162-3c718871d138.png). 
![Picture3](https://user-images.githubusercontent.com/20412445/84295710-8ce70c00-ab10-11ea-9027-cc69327111c3.png). 
![Picture4](https://user-images.githubusercontent.com/20412445/84295717-8e183900-ab10-11ea-8e7c-232db27b21c6.png). 
![Picture5](https://user-images.githubusercontent.com/20412445/84295723-8f496600-ab10-11ea-8833-aed15862ddc9.png). 



