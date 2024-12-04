# RadioGaGa

A simple implementation of an online radio for Raspberry Pi.

## Introduction

This is a simple implementation of an online radio for Raspberry Pi. While there's definitely room for improvement and expansion, I’m sharing the project along with a short installation guide. I hope others find it useful!

## Installation Guide

### Prerequisites
- Raspberry Pi with a compatible OS (e.g., Raspberry Pi OS).
- Basic knowledge of terminal commands.
- Stable internet connection.

### Steps

1. Prepare the environment by installing the necessary packages:
   ```bash
   apt-get install apache2
   apt-get install python2
   apt-get install openssh-server
   apt-get install php7.4
   apt-get install mplayer
   ```

2. Enable ssh for Raspberry Pi (in configuration UI)

3. Enable analog audio (hdmi off, AVJack on)

4. Navigate to your home directory on the Raspberry Pi and create a `radio` folder:
   ```bash
   cd ~
   mkdir radio
   ```
5. Copy files from the `python` folder of the repository into the new `radio` directory

6. Change the permissions of the following files:
   ```bash
   chmod 777 /home/<yourname>/radio/active.txt
   chmod 777 /home/<yourname>/radio/radio.list
   ```
7. Change the owner and group to the web server user for the following files:
   ```bash
   chown www-data:www-data /home/<yourname>/radio/keep_mplayer_alive.py
   chown www-data:www-data /home/<yourname>/radio/kill_mplayer.py
   ```
8. Add the script `a.py` to cron for the `www-data` user:
   ```bash
   sudo crontab -u www-data -e
   * * * * * python2 /home/<yourname>/radio/a.py
   ```
9. Add `www-data` user to `audio` group:
   ```bash
   sudo usermod -a -G audio www-data


## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments
Thanks to the open-source community for inspiring and supporting this project!
   
   ```

   
