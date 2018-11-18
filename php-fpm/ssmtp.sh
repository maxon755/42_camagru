#!/bin/bash

source /etc/ssmtp/ssmtp.env

sed -i 's/SSMTP_LOGIN/'"$SSMTP_LOGIN"'/g' /etc/ssmtp/ssmtp.conf
sed -i 's/SSMTP_PASSWORD/'"$SSMTP_PASSWORD"'/g' /etc/ssmtp/ssmtp.conf
sed -i 's/SSMTP_HUB/'"$SSMTP_HUB"'/g' /etc/ssmtp/ssmtp.conf
sed -i 's/SSMTP_PORT/'"$SSMTP_PORT"'/g' /etc/ssmtp/ssmtp.conf


sed -i 's/SSMTP_LOGIN/'"$SSMTP_LOGIN"'/g' /etc/ssmtp/revaliases
sed -i 's/SSMTP_HUB/'"$SSMTP_HUB"'/g' /etc/ssmtp/revaliases
sed -i 's/SSMTP_PORT/'"$SSMTP_PORT"'/g' /etc/ssmtp/revaliases
