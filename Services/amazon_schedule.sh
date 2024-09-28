RESULT=$(systemctl is-active amazon_schedule.service)

mkdir -p "/home/amazon/logs"

if [ $RESULT !=  "active" ]; then

RES=$(systemctl status amazon_schedule.service)

echo "$RES" >> "/home/amazon/logs/errorlog.$(date +'%Y-%m-%d-%T').log"

systemctl start amazon_schedule.service

fi
