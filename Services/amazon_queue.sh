RESULT=$(systemctl is-active amazon_queue.service)

mkdir -p "/home/amazon/logs"

if [ $RESULT !=  "active" ]; then

RES=$(systemctl status amazon_queue.service)

echo "$RES" >> "/home/amazon/logs/errorlog.$(date +'%Y-%m-%d-%T').log"

systemctl start amazon_queue.service

fi
