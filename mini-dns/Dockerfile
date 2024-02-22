FROM alpine:latest

RUN apk add --no-cache dnsmasq

EXPOSE 53 53/udp
CMD ["dnsmasq", "-k", "-C", "/etc/dnsmasq.conf"]
