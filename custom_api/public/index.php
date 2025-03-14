<?php
echo "<h1>Instruction</h1> <br>";

echo "sudo apt update -y <br>";
echo "sudo apt upgrade -y <br>";

echo "sudo add-apt-repository universe <br>";
echo "sudo apt install -y gnome-tweaks <br>";

echo "<h1>SSH</h1> <br>";

echo "ssh-keygen -t ed25519 -C \"your_email@example.com\" <br>";
echo 'eval "$(ssh-agent -s)"<br>';
echo 'ssh-add ~/.ssh/id_ed25519<br>';
echo 'cat ~/.ssh/id_ed25519.pub<br>';

echo "<h2>Github repo</h2> <br>";
echo '<a href="https://github.com/ImperatorYarik/React-Symfony-docker-template.git">GitRepo</a><br>';


echo "<h1>Install Docker</h1> <br>";

echo "<a href='https://docs.docker.com/engine/install/ubuntu/'>Install docker ubuntu</a><br>";
echo "<a href='https://desktop.docker.com/win/main/amd64/Docker%20Desktop%20Installer.exe?utm_source=docker&utm_medium=webreferral&utm_campaign=dd-smartbutton&utm_location=module'>Install docker Windows 11 (з WSL)</a> <br>";
echo "<a href='https://desktop.docker.com/mac/main/amd64/Docker.dmg?utm_source=docker&utm_medium=webreferral&utm_campaign=dd-smartbutton&utm_location=module'>Install MacOS intel</a> <br>";
echo "<a href='https://desktop.docker.com/mac/main/arm64/Docker.dmg?utm_source=docker&utm_medium=webreferral&utm_campaign=dd-smartbutton&utm_location=module'>Install MacOS Silicon</a> <br><br>";

echo "
sudo apt-get update <br>
sudo apt-get install ca-certificates curl <br>
sudo install -m 0755 -d /etc/apt/keyrings <br>
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc <br>
sudo chmod a+r /etc/apt/keyrings/docker.asc <br>

echo \
  \"deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo \"\${UBUNTU_CODENAME:-\$VERSION_CODENAME}\") stable\" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null <br>
sudo apt-get update <br>";

echo 'sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin<br>';



echo "<h1>Install browser</h1> <br>";

echo "wget https://dl.google.com/linux/direct/google-chrome-
stable_current_amd64.deb -P Downloads/ <br>";

echo "sudo dpkg -i --force-depends Downloads/google-chrome-
stable_current_amd64.deb <br>";