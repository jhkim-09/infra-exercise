# -*- mode: ruby -*-
# vi: set ft=ruby :

## variable setting ##
vm_names = ["LB1","LB2","WEB1","WEB2","DB1","DB2","NFS","iSCSI","DNS"]
vm_image = "generic/rocky9"
vm_cpus = 2
vm_memory = 2048
vm_subnet = "192.168.56."
disk_name = "iscsi.vdi"

## script setting ##
vm_script = <<-SCRIPT
  # Password Authentication for SSH
  sed -i 's/PasswordAuthentication no/PasswordAuthentication yes/g' /etc/ssh/sshd_config
  sed -i 's/PermitRootLogin no/PermitRootLogin yes/g' /etc/ssh/sshd_config
  systemctl restart sshd
SCRIPT

## VM setting ##
# 가상 머신 이름을 배열로 정의
Vagrant.configure("2") do |config|
  vm_names.each_with_index do |name, index|
    config.vm.define name do |node|
      node.vm.box = vm_image
      node.vm.hostname = name
      node.vm.network "private_network", ip: "#{vm_subnet}#{10 + index}"
      node.vm.provision "shell", inline: vm_script
      node.vm.provider "virtualbox" do |vb|
        vb.name = name
        vb.cpus = vm_cpus
        vb.memory = vm_memory
        if name == "iSCSI"
            unless File.exist?(disk_name)
                vb.customize ['createmedium', 'disk', '--format', 'VMDK', '--filename', disk_name, '--size', 20480]
            end
            vb.customize ['storageattach', :id, '--storagectl', 'SATA Controller', '--port', 2, '--device', 0, '--type', 'hdd', '--medium', disk_name]
        end      
      end
    end
  end
end