FROM ubuntu:18.04

RUN apt update
RUN apt upgrade -y

RUN apt install software-properties-common -y
RUN add-apt-repository ppa:deadsnakes/ppa
RUN apt install python3.6 -y
RUN ln -s /usr/bin/pip3 /usr/bin/pip
RUN ln -s /usr/bin/python3.6 /usr/bin/python

RUN python3 --version
RUN apt-get update && apt-get install -y python3-pip
RUN pip3 install --upgrade pip

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN pip3 install git+git://github.com/jaredwinick/img2vec-keras.git
RUN pip3 install numpy
RUN pip3 install yake
RUN pip3 install scikit-learn
RUN pip3 install urllib3
RUN pip3 install requests
RUN pip3 install google-search-results

ENV PYTHONIOENCODING=utf-8
COPY ./src /usr/shopping
COPY ./json /var/www/files
