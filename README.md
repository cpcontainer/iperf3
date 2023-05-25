# iperf3
#### Docker Container running iPerf3 with web interface for Cradlepoint routers

## Setup:
Create a new container project in your Cradlepoint router and give it a name then click to the "compose" tab.
Copy and paste the following compose into your project and click save.

## Compose:
```yaml
version: '3'
services:
  iperf3:
    image: "cpcontainer/iperf3"
    ports:
     - '8000:80'
     - '5201:5201'
```

## Usage:
In NetCloud Manager, create a LAN Manager profile for "iPerf3" with IP address 127.0.0.1 port 8000 protocol HTTP.
Click Connect on the profile you created.

## Screenshot:
![image](https://github.com/cpcontainer/iperf3/assets/127797701/f6063149-d4a7-411d-a677-649d25edbe28)

## Notes:

The "additional options" box is to supply command line parameters to iPerf3 for various options.

For TCP DL tests
```
-P 5 -i 1 -t 10
```

For TCP uploads, use -R for reverse mode:
```
-b 100M -R -P 5 -i 1 -t 10
```

For UDP Downloads:
```
u -b 100M -P 5 -i 1 -t 10
```

For UDP Uploads, use -R for reverse mode
```
-u -b 100M -R -P 5 -i 1 -t 10
```

## Docker Hub:
https://hub.docker.com/r/cpcontainer/iperf3
