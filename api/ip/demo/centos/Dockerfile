FROM centos:latest

# 配置阿里云镜像源
RUN mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.bak \
    && curl -o /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo \
    && yum clean all \
    && yum makecache

# 安装常用工具
RUN yum install -y wget net-tools bind-utils

CMD ["/bin/bash"]