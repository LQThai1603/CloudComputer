#VPC setting:

- resources to create: VPC only
- Namem tag: my-vpc-1
- IPV4 CIDR block: IPV4 CIDR manual input
- IPV4 CIDR : 10.0.0.26
- IPV6 CIDR block: No IPV6 CIDR block
- Tenancy: default

#Create subnet:

- vpc id: my-vpc-1

- create 2 subnet: publicsubnet(public-sb1, public-sb2)
- create 2 subnet: privatesubnet(private-sb1, private-sb2)

- create route table: publicRT: gồm 2 mạng public-sb1, public-sb2
- create route table: privateRT: gồm 2 mạng private-sb1, private-sb2

#create internet gateway:

- name tag: myIGW
- attach to VPC:

  - Avaiable VPCs: my-vpc-1

- Edit route cho route public-RT:
  - add route:
    - destination: 0.0.0.0/0
    - target: myIGW

#create NAT gateway:

- name: mynat
- subnet: public-sb1
- connectivity type: public

- Edit route cho route private-RT: (lưu RDS trên các private-sb, khi tải bản vá nào thì cần NAT gateway để tải các bản vá từ internet)
  - add route:
    - destination: 0.0.0.0/0
    - target: mynat

#create DB sunet group:

- name: mySubGroup
- description: this is my DB subnet Group
- choose a VPC: my-vpc-1
- Avaiable zones: us-east-1a, us-east-1b
- subnets: subnet-0ea7da5aa94082f09, subnet-0a6633b5ac7c56826

#create database:

- Standard create
- MySQL
- Engine Version: MySQL 8.0.34
- templates: Free tier
- settings:
  - myRDS
  - credentials Settings:
    - Master username: admin
    - Master password: Th08655490!6
    - confirm master password: Th08655490!6
  - conectivity:
    - VPC: my-vpc-1
    - puvlic access: yes
    - VPC security group:
      - create new:
        - name: mySG1
        - Avaiable zones: no preference

#EC2:
#AMI catalog: slect Amazon linux 2 AMI

- langch an instance

  - name: mywebserver1
  - key pair: key
  - network settings:
    - VPC: my-vpc-1
    - subnet: public-sb1
    - firewall: select existing security group
    - common security groups: mySG1

- security group: mySG1
- edit inbound rules:
  - type: MySQL, CDIR block: 10.0.0.10
  - type: SSH, CDIR block: 10.0.0.0
  - type: HTTP, CDIR block: 10.0.0.0

#EC2 terminal:

- sudy yum update -y
- install php8.0

  - sudo amazon-linux-extras | grep php
  - sudo amazon-linux-extras enable php8.0
  - sudo yum clear metadata
  - sudo yum install php-cli php-pdo php-fpm php-mysqlnd -y
  - php -v

- install apache HTTP server:

  - sudo yum install httpd -y
  - sudo systemctl start httpd
  - sudo systemctl end httpd

- to check apache from browser
  - ec2-54-152-253-93.compute-1.amazonaws.com
  - sudo usermod -a -G apache ec2-user
  - exit
  - groups
  - sudo chown -R ec2-user:apache /var/www
  - sudo chmod 2775 /var/www
  - find var/www -type d -exec sudo chmod 2775 {} \;
  - find var/www -type f -exec sudo chmod 0664 {} \;
  - sudo yum telnet -y
  - sudo yum install telnet -y
  - telnet myrds.cqowwhyh3xda.us-east-1.rds.amazonaws.com 3306
  - sudo yum install mysql -y
  - mysql -hmyrds.cqowwhyh3xda.us-east-1.rds.amazonaws.com -uadmin -p
  - password: Th08655490!6
  - create database ...
  - exit
  - cd var/www/html
  - tạo các file như trên github(https://github.com/LQThai1603/CloudComputer/tree/master)
